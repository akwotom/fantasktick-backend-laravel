<?php
/**
 * Copyright 2024 Son of Binary
 * The Fantasktick Project
 * This controller provides an API for managing tasks.
 */


namespace App\Http\Controllers;
use App\Models\Task;
use \Illuminate\Http\Request;
use \Illuminate\Validation\Validator;

class TaskApi extends Controller
{


    /**
     * This method returns all tasks on the system, paginated
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {

        $filterKeys = ['status', 'date', 'id'];
        $searchKeys = ['label', 'description'];

        $filter = array();

        foreach ($filterKeys as $fK) {
            if (isset($request->$fK)) {
                $filter[$fK] = $request->$fK;
            }
        }



        $query = Task::select(array('*'))->where(
            $filter
        );

        if (isset($request->search)) {

            $query = $query->where(function ($query) use ($request, $searchKeys) {
                foreach ($searchKeys as $sK) {
                    $query = $query->orWhereLike(
                        $sK,
                        '%' . ($request->search) . '%'
                    );
                }
                return $query;
            });
        }

        $tasks = $query->paginate(50, $request->page);


        return response()->json(
            $tasks
        );
    }


    public function create(Request $request)
    {
        $input = $request->jsonContent;

        $task = new Task(
            array(
                'label' => $input['label'],
                'description' => $input['description'],
                'date' => $input['date'],

            ),
        );


        $task->save();

        return response()->json(
            array(
                'data' => array(
                    'id' => $task['id'],
                ),
            ),
        );
    }


    /**
     * This method updates a task in the db
     * @param \Illuminate\Http\Request $request
     *
     */
    public function update(Request $request)
    {
        $input = $request->jsonContent;


        Task::where('id', $input['id'])->update(

            array_filter(
                array(
                    'label' => isset($input['label']) ? $input['label'] : NULL,
                    'description' => isset($input['description']) ? $input['description'] : NULL,
                    'date' => isset($input['date']) ? $input['date'] : NULL,
                    'status' => isset($input['status']) ? $input['status'] : NULL
                ),
                function ($item) {
                    return $item != NULL;
                }
            )

        );
        return response()->json(
            array(
                'success' => true,
                'data' => array()
            )
        );
    }


}
