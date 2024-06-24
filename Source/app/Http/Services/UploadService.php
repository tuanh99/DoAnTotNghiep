<?php


namespace App\Http\Services;


class UploadService
{
    public function store($request)
    {
        if ($request->hasFile('file')) {
            try {
                $name = $request->file('file')->getClientOriginalName();
                $pathFull = 'uploads/' . date("Y/m/d");

                $request->file('file')->storeAs(
                    'public/' . $pathFull, $name
                );

                return '/storage/' . $pathFull . '/' . $name;
            } catch (\Exception $error) {
                return false;
            }
        }
    }



//     public function store(Request $request)
// {
//     if ($request->hasFile('file')) {
//         try {
//             $file = $request->file('file');
//             $originalName = $file->getClientOriginalName();
            
//             // Tạo tên duy nhất cho tệp tin
//             $fileName = pathinfo($originalName, PATHINFO_FILENAME);
//             $extension = $file->getClientOriginalExtension();
//             $fileNameToStore = $fileName.'_'.time().'.'.$extension;

//             // Thư mục lưu trữ dựa trên ngày tháng
//             $pathFull = 'uploads/' . date("Y/m/d");

//             // Lưu tệp tin vào thư mục lưu trữ
//             $storedPath = $file->storeAs(
//                 'public/' . $pathFull, $fileNameToStore
//             );

//             // Trả về đường dẫn tới tệp tin đã lưu
//             return '/storage/' . $pathFull . '/' . $fileNameToStore;
//         } catch (\Exception $error) {
//             // Xử lý lỗi và trả về false hoặc thực hiện các hành động cần thiết
//             return false;
//         }
//     }
// }
}
