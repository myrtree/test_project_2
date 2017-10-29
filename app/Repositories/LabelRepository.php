<?php

namespace App\Repositories;

use App\Models\Label;

class LabelRepository
{
    public function create(array $data): Label
    {
        return Label::create($data);
    }

    public function update(Label $label, array $data): Label
    {
        $label->fill($data);
        $label->save();

        return $label;
    }

    public function delete(Label $label)
    {
        $label->delete();
    }

    public function getById(int $id)
    {
        return Label::where('id', $id)->first();
    }

    public function getByName(string $name)
    {
        return Label::where('name', $name)->first();
    }
}
