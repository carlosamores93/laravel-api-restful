<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ExceptionTrait{

	public function apiException($request, $e){
		if($this->isModel($e)){
			return $this->ResponseModel();
        }
        if($this->isHttp($e)){
        	return $this->HttpModel();
        }

        return parent::render($request, $e);
	}

	protected function isModel($e){
		return $e instanceof ModelNotFoundException;
	}
	protected function isHttp($e){
		return $e instanceof NotFoundHttpException;
	}

	protected function ResponseModel(){
		return response()->json([
	            'error' => 'Product Model not found'
	        ], Response::HTTP_NOT_FOUND);
	}

	protected function HttpModel(){
		return response()->json([
                'error' => 'Incorrect route'
            ], Response::HTTP_NOT_FOUND);
	}
}