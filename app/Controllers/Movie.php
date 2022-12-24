<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MovieModel;

class Movie extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new MovieModel();
        $data = $model->orderBy('id', 'DESC')->findAll();
        // console.log($data);
        return $this->respond($data);
    }
    // create
    public function create()
    {
        $rules = [
			"title" => "required",
            "description" => "required"
		];

		$messages = [
			"title" => [
				"required" => "Title is required"
			],
            "description" => [
                "required" => "Description is required"
            ]
		];

		if (!$this->validate($rules, $messages)) {
            $response = [
				'status' => 500,
				'error' => true,
				'message' => $this->validator->getErrors(),
				'data' => []
			];
        }else{
            $model = new MovieModel();
            $data = [
                'title' => $this->request->getVar('title'),
                'description'  => $this->request->getVar('description'),
                'rating'  => $this->request->getVar('rating'),
                'image'  => $this->request->getVar('image'),
            ];
            $model->insert($data);
            $response = [
                'status'   => 201,
                'error'    => null,
                'messages' => [
                    'success' => 'Movie successfully inserted.'
                ],
                'data'     => $data
            ];
        }
        return $this->respondCreated($response);
        
    }

    public function show($id = null)
    {
        $model = new MovieModel();
        $data = $model->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Movie not Found.');
        }
    }

    public function update($id = null)
    {   
        $rules = [
			"title" => "required",
            "description" => "required",
            "rating" => "required|decimal",
		];

		$messages = [
			"title" => [
				"required" => "Title is required"
			],
            "description" => [
                "required" => "Description is required"
            ],
            "rating" => [
                "required" => "rating is required",
                "decimal" => "rating supposed to be decimal"
            ]
		];
        if (!$this->validate($rules, $messages)) {
            $response = [
				'status' => 500,
				'error' => true,
				'message' => $this->validator->getErrors(),
				'data' => []
			];
        }else{
            $model = new MovieModel();
            // $id = $this->request->getVar('id');
            // dd($id);
            
            if($model->where('id',$id)->first() != null ){

                $json = $this->request->getJSON();
                if($json){
                    $data = [
                        'title' => $json->title,
                        'description' => $json->description,
                        'rating' => $json->rating,
                        'image' => $json->image
                    ];
                }else{
                    $input = $this->request->getRawInput();
                    $data = [
                        'title' => $input['title'],
                        'description' => $input['description'],
                        'rating' => $input['rating'],
                        'image' => $input['image']
                    ];
                }

                $model->update($id, $data);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Movie Successfully updated.'
                    ],
                    'data' => $model->where('id',$id)->first()
                ];
            }else{
                $response = [
					'status' => 500,
					"error" => true,
					'messages' => 'Movie Not Found',
					'data' => []
				];
            }
            
        }
        
        return $this->respond($response);
    }

    public function delete($id = null)
    {
        $model = new MovieModel();
        $data = $model->where('id', $id)->first();
        if ($data) {
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Movie with id: '.$id.' Successfully deleted.'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Movie Not Found.');
        }
    }
}
