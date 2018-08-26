<?php

namespace app\Controller;


use app\Database\Database;
use app\Model\DeviceOrder;
use app\Request\Request;
use app\Response\Response;
use app\Validator\GetValidator;
use app\Validator\InsertValidator;
use app\Validator\Validator;

class Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function insert()
    {
        $data = $this->request->getPost();

        $validator = new InsertValidator($data);

        if (!$validator()) {
            return [Response::BAD_REQUEST, [$validator->getErrors()]];
        }

        $deviceOrder = new DeviceOrder();
        $deviceOrder->setData($data);

        if ($deviceOrder->isValid()) {
            $deviceOrder->save();

            return [
                Response::OK, []
            ];
        } else {
            return [Response::BAD_REQUEST, [
                'error' => 'device work hours for this weekday is already defined'
            ]];
        }
    }

    public function get()
    {
        $data = $this->request->getPost();

        $validator = new GetValidator($data);

        if (!$validator()) {
            return [Response::BAD_REQUEST, [$validator->getErrors()]];
        }

        $data['n'] = isset($data['n']) ? $data['n'] : 0;
        $results = DeviceOrder::findFromDate($data['date'], $data['n']);

        $responseData = [];
        for ($i = 0; $i < $data['n']; $i++) {
            $fromDate = date('Y-m-d', strtotime(sprintf('%s +%s days', $data['date'], $i)));
            $weekday = date('N', strtotime($fromDate)) - 1;

            $hours = [];
            foreach ($results as $result) {
                if ($result['weekday'] == Validator::WEEKDAYS[$weekday]) {
                    $hours[] = $result['hours'];
                }
            }
            $responseData[] = [
                'date' => $fromDate,
                'hours' => $hours
            ];
        }

        return [
            Response::OK,
            $responseData
        ];
    }
}