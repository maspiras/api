<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\LazyCollection;
use Illuminate\Database\Eloquent\Collection;

class BaseRepository
{
    /**
     * The Model name.
     *
     * @var \Illuminate\Database\Eloquent\Model;
     */
    protected $model;

    public function latest(){
        return $this->model->latest()->get();

        /* $rooms = collect();
        Room::chunk(5, function($myrooms) use($rooms) {
            foreach($myrooms as $r)
                $rooms->push($r);	
        }); */
    }

    /* public function chunk($limit, callable $callback)
    {
        $this->applyCriteria();
        $this->applyScope();
    
        if($this->model instanceof Illuminate\Database\Eloquent\Builder) {
            $modelQuery = $this->model->getQuery();
        } else {
            $modelQuery = $this->model;
        }
        
        $underlyingQueryBuilder = $modelQuery->getQuery();
        if (empty($underlyingQueryBuilder->orders) && empty($underlyingQueryBuilder->unionOrders)) {
            $this->model->orderBy($modelQuery->getModel()->getQualifiedKeyName(), 'asc');
        }
        
        $presenterFunction = \Closure::bind(function($results,$page) use (&$callback) {
            return $callback($this->parserResult($results), $page);
        }, $this);
    
        return $this->model->chunk($limit, $presenterFunction);
    } */

    public function all()
    {
        $data = collect();
        #$this->roomRepository->all()
        #$rooms = collect();
        $this->model->where('host_id', auth()->user()->host_id)->chunkById(100, function($mydata) use($data) {
            foreach($mydata as $r)
                $data->push($r);	
        }, column: 'id');
        
        return $data;
    }
    /**
     * Paginate the given query.
     *
     * @param The number of models to return for pagination $n integer
     *
     * @return mixed
     */
    public function getPaginate($n)
    {
        return $this->model->where('host_id', auth()->user()->host_id)->paginate($n);
    }

    public function simplePaginate($n)
    {
        return $this->model->simplePaginate($n);
    }

    /**
     * Create a new model and return the instance.
     *
     * @param array $inputs
     *
     * @return Model instance
     */
    public function store(array $inputs)
    {
        return $this->model->create($inputs);
    }

    public function insert(array $inputs)
    {
        return $this->model->insert($inputs);
    }

    public function massiveInsert($data){
        $insert_data = collect($data); // Make a collection to use the chunk method
        // it will chunk the dataset in smaller collections containing 200 values each. 
        // Play with the value to get best result
        $chunks = $insert_data->chunk(200);
        foreach ($chunks as $chunk)
        {
        //\DB::table('items_details')->insert($chunk->toArray());
            $this->insert($chunk->toArray());
        }
    }

    public function insertGetId(array $inputs){
        return $this->model->insertGetId($inputs);
    }

    /**
     * FindOrFail Model and return the instance.
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    /* public function getById($id)
    {
        return $this->model->findOrFail($id);
    } */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Update the model in the database.
     *
     * @param $id
     * @param array $data
     */
    public function update(int $id, array $data)
    {
        //$this->getById($id)->update($inputs);
        /* $result = $this->find($id);
        if (!$result) {
            return false;
        }
        return $result->update($data); */
        return $this->model->where('id', $id)
                    ->update($data);
    }

    /**
     * Delete the model from the database.
     *
     * @param int $id
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->find($id)->delete();
    }

    public function toArr($arr){
        return json_decode(json_encode($arr), true);
    }
}
