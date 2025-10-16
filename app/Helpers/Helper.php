<?php
if (!function_exists('printJson')) {
     function printJson($data, $statusObject = null, $lang = null){
        if($statusObject == null){
            $statusObject = buildStatusObject('HTTP_OK');
        };
        $response = [];
        $response['status'] = $statusObject->code;
        $response['status_code'] = $statusObject->status_code;
        $response['message'] = ($lang == 'en') ? $statusObject->message_en : $statusObject->message;
         // Kiểm tra nếu dữ liệu là đối tượng phân trang (Paginator)
         if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $response['data'] = [
                'data' => $data->items(),
                'links' => [
                    'first' => $data->url(1),
                    'last' => $data->url($data->lastPage()),
                    'prev' => $data->previousPageUrl(),
                    'next' => $data->nextPageUrl(),
                ],
                'meta' => [
                    'current_page' => $data->currentPage(),
                    'from' => $data->firstItem(),
                    'last_page' => $data->lastPage(),
                    'links' => generatePaginationLinks($data),
                    'path' => $data->path(),
                    'per_page' => $data->perPage(),
                    'to' => $data->lastItem(),
                    'total' => $data->total(),
                ],
            ];
        } elseif ($data instanceof \Illuminate\Http\Resources\Json\ResourceCollection) {
            // Nếu là ResourceCollection, lấy dữ liệu và phân trang
            $response['data'] = [
                'data' => $data->resource->items(),
                'links' => [
                    'first' => $data->url(1),
                    'last' => $data->url($data->lastPage()),
                    'prev' => $data->previousPageUrl(),
                    'next' => $data->nextPageUrl(),
                ],
                'meta' => [
                    'current_page' => $data->currentPage(),
                    'from' => $data->firstItem(),
                    'last_page' => $data->lastPage(),
                    'links' => generatePaginationLinks($data),
                    'path' => $data->path(),
                    'per_page' => $data->perPage(),
                    'to' => $data->lastItem(),
                    'total' => $data->total(),
                ],
            ];
        } else {
            // Nếu không phải phân trang, trả về dữ liệu bình thường
            $response['data'] = $data;
        }
        return response()->json($response);
    }
}

if (!function_exists('generatePaginationLinks')) {
    function generatePaginationLinks($paginator)
    {
        $links = [];
        $totalPages = $paginator->lastPage();
        for ($page = 1; $page <= $totalPages; $page++) {
            $links[] = [
                'url' => $paginator->url($page),
                'label' => $page,
                'active' => $paginator->currentPage() == $page
            ];
        }

        if ($paginator->currentPage() > 1) {
            $links[] = [
                'url' => $paginator->previousPageUrl(),
                'label' => '&laquo; Previous',
                'active' => false
            ];
        }

        if ($paginator->currentPage() < $totalPages) {
            $links[] = [
                'url' => $paginator->nextPageUrl(),
                'label' => 'Next &raquo;',
                'active' => false
            ];
        }

        return $links;
    }
}

if (!function_exists('buildStatusObject')) {
    function buildStatusObject($status){
        $statusCodeObject = app('StatusCodeObjectClass')->getObject($status);
        return $statusCodeObject;
    }
}