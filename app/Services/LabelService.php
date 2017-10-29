<?php

namespace App\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Label;
use App\Repositories\LabelRepository;

class LabelService
{
    private $labelRepository;

    public function __construct(LabelRepository $labelRepository)
    {
        $this->labelRepository = $labelRepository;
    }

    public function create(array $data): Label
    {
        $label = $this->labelRepository->getByName($data['name']);
        if ($label) {
            return $label;
        }

        return $this->labelRepository->create($data);
    }

    public function update(Label $label, array $data): Label
    {
        return $this->labelRepository->update($label, $data);
    }

    public function getById(int $id): Label
    {
        $label = $this->labelRepository->getById($id);

        if (!$label) {
            throw new NotFoundHttpException("Meeting with id '$id' not found");
        }

        return $label;
    }

    public function delete(Label $meeting)
    {
        $this->labelRepository->delete($meeting);
    }
}
