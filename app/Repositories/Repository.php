<?php

namespace App\Repositories;

use App\Interfaces\Repositories\IRepository;
use App\Interfaces\Traits\IHasValidation;
use Exception;
use Illuminate\Support\Facades\DB;

class Repository implements IRepository
{
    public function tableToUse(): string
    {
        throw new Exception('Pending implementation of tableToUse.');
    }

    public function rawUpdateValuesQueryArray(IHasValidation $data): array
    {
        $finalQuery = '';
        $valueArray = [];
        foreach ($data->rawArray() as $key => $value) {
            $finalQuery = $finalQuery . ' ' .$key.'=?';
            $valueArray[] = $value;
        }
        return [$finalQuery, $valueArray];
    }
    public function rawCreateValuesQueryArray(IHasValidation $data): array
    {
        $keyQuery = '';
        $questionQuery = '';
        $valueArray = [];
        foreach ($data->rawArray() as $key => $value) {
            $keyQuery = $keyQuery .$key .',';
            $valueArray[] = $value;
            $questionQuery = $questionQuery . '?,';
        }
        $questionQuery = substr_replace($questionQuery, '', -1);
        $keyQuery = substr_replace($keyQuery, '', -1);
        return ['('.$keyQuery .')'. ' VALUES ' . '('.$questionQuery .')', $valueArray ];
    }

    public function create(?IHasValidation $data = null): void
    {
        $to_create = $data ?? $this;
        $to_create->validate();
        [$query, $array] = $this->rawCreateValuesQueryArray($to_create);
        DB::insert('INSERT INTO '.$this->tableToUse().' '.$query, $array);
    }

    public function delete(int $id): void
    {
        DB::delete('DELETE FROM '.$this->tableToUse().' WHERE Id=?', [$id]);
    }

    public function update(int $id, ?IHasValidation $data = null): void
    {
        $to_update = $data ?? $this;
        $to_update->validate();
        [$query, $array] = $this->rawUpdateValuesQueryArray($to_update);
        $array[] = $id;
        DB::update('UPDATE '.$this->tableToUse().' SET ' . $query.'WHERE id=?', $array);
    }
}
