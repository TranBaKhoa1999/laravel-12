<?php
namespace App\Core;
class StatusCodeObject{

    const HTTP_OK = [
        'code' => 200,
        'status_code' => 'HTTP_OK',
        'message' => 'Thành Công',
        'message_en' => 'Success',
    ];

    const INTERNAL_SERVER_ERROR = [
        'code' => 500,
        'status_code' => 'INTERNAL_SERVER_ERROR',
        'message' => 'Lỗi hệ thống',
        'message_en' => 'Internal server error',
    ];

    const SERVICE_UNAVAILABLE = [
        'code' => 503,
        'status_code' => 'SERVICE_UNAVAILABLE',
        'message' => 'Hệ thống đang bảo trì',
        'message_en' => 'Service unavailable',
    ];

    const INVALID_INPUT = [
        'code' => 400,
        'status_code' => 'INVALID_INPUT',
        'message' => 'Đầu vào không hợp lệ',
        'message_en' => 'Invalid Input',
    ];

    const PAGE_NOT_FOUND = [
        'code' => 404,
        'status_code' => 'PAGE_NOT_FOUND',
        'message' => 'Trang không tồn tại',
        'message_en' => 'Page not found',
    ];

    const UNAUTHORIZED = [
        'code' => 401,
        'status_code' => 'UNAUTHORIZED',
        'message' => 'xác thực không thành công',
        'message_en' => 'Unauthorized',
    ];
    
    const FORBIDDEN = [
        'code'  => 403,
        'status_code' => 'FORBIDDEN',
        'message'  => 'Không có quyền truy cập',
        'message_en' => 'Forbiden',
    ];

    const METHOD_NOT_ALLOWED = [
        'code'  => 405,
        'status_code' => 'METHOD_NOT_ALLOWED',
        'message' => 'phương thức không hỗ trợ',
        'message_en' => 'Method not allowed',
    ];

    const REQUEST_TIMEOUT = [
        'code' => 408,
        'status_code' => 'REQUEST_TIMEOUT',
        'message'   => 'thời gian phản hồi quá lâu',
        'message_en' => 'Response Time out',
    ];

    const GATEWAY_TIMEOUT =[
        'code' => 504,
        'status_code' => 'GATEWAY_TIMEOUT',
        'message' => 'Gateway timeout',
        'message_en' => 'Gateway timeout',
    ];

    const UNPROCESSABLE_ENTITY = [
        'code' => 422,
        'status_code' => 'UNPROCESSABLE_ENTITY',
        'message' => 'Dữ liệu không hợp lệ',
        'message_en' => 'Unprocessable Entity',
    ];

    public static function getObject($status){
       if(defined('self::'.$status)){
            return (object)constant("self::".$status);
       }else{
            return (object)constant("self::INTERNAL_SERVER_ERROR");
       }   
    }
}