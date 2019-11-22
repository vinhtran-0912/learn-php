<?php

/**
 * @SWG\Swagger(
 *     schemes={"https", "http"},
 *     @SWG\Info(
 *         title="CRM Swagger API",
 *         description="CRM API description",
 *         version="1.0.0"
 *     )
 * )
 * 
 *  @SWG\Definition(
 *     definition="InternalServerError",
 *     description="Internal server error!",
 *     required={"error_code", "error_description"},
 *     @SWG\Property(
 *         property="error_code",
 *         type="string",
 *         example="500",
 *     ),
 *     @SWG\Property(
 *         property="error_description",
 *         type="string",
 *         example="Internal server error!"
 *     )
 * )
 *
 *  @SWG\Definition(
 *     definition="AuthenticationError",
 *     required={"error_code", "error_description"},
 *     @SWG\Property(
 *         property="error_code",
 *         type="string",
 *         example="1002",
 *     ),
 *     @SWG\Property(
 *         property="error_description",
 *         type="string",
 *         example="認証できませんでした。認証情報をご確認お願いします。"
 *     )
 * )
 * 
 * @SWG\Tag(
 *     name="Authorization",
 *     description="Authorization function"
 * )
 */
