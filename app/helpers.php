<?php

if( !function_exists( 'apiRequestValidationErrors' ) ) {
    function apiRequestValidationErrors( $validator )
    {
        // if ($validator->fails()) {
        $errors = $validator->errors();
        $validationErrors = [];
        foreach( $errors->getMessages() as $key => $values ) {
            $errorCount = count( $values );
            foreach( $values as $cerror ) {
                $validationErrors[ $key . '_' . $errorCount ] = $cerror;
                $errorCount--;
            }
        }

        return response()->json(
            [
                'status' => false,
                'message' => $validationErrors,
                'data' => null,
                'stauts_code' => '400'
            ],
            200
        );
        // }
    }
}

if( !function_exists( 'apiErrorResponse' ) ) {
    function apiErrorResponse( $message, $key = null )
    {
        if( !is_null( $key ) ) {
            return response()->json(
                [
                    'status' => false,
                    'message' => [
                        $key => $message,
                    ],
                    'data' => null,
                    'stauts_code' => '400'
                ]
            );
        }
        return response()->json(
            [
                'status' => false,
                'message' => [
                    'error' => $message,
                ],
                'data' => null,
                'stauts_code' => '400'
            ]
        );
    }
}
