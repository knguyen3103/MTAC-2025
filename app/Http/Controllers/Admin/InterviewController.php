<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interview;
use App\Models\Applicant;
use Illuminate\Support\Facades\Mail;
use App\Mail\InterviewInvitationMail;

class InterviewController extends Controller
{
    /**
     * Hiển thị form gửi thư mời dựa trên danh sách ứng viên đã duyệt
     */
    /**
 * Hiển thị form gửi thư mời
 */
public function sendInvitationForm()
    {
        $candidates = Applicant::where('status', 'Đã duyệt')->get();
        return view('admin.interviews.invitation', compact('candidates'));
    }
    
    public function sendInvitation(Request $request)
    {
        $request->validate([
            'applicant_id'   => 'required|exists:applicants,id',
            'full_name'      => 'required|string|max:255',
            'email'          => 'required|email',
            'position'       => 'required|string|max:255',
            'interview_time' => 'required|date',
            'note'           => 'nullable|string',
        ]);

        // 1. Lưu vào bảng interviews
        $interview = Interview::create([
            'applicant_id'   => $request->applicant_id,
            'full_name'      => $request->full_name,
            'email'          => $request->email,
            'position'       => $request->position,
            'interview_time' => $request->interview_time,
            'note'           => $request->note,
            'status'         => 'Đã gửi thư mời'
        ]);

        // 2. Gửi email đến ứng viên
        try {
            Mail::to($request->email)->send(new InterviewInvitationMail([
                'full_name'      => $request->full_name,
                'email'          => $request->email,
                'position'       => $request->position,
                'interview_time' => $request->interview_time,
                'note'           => $request->note
            ]));
        } catch (\Exception $e) {
            return back()->with('error', '❌ Gửi email thất bại: ' . $e->getMessage());
        }

        // 3. (Tùy chọn) Cập nhật trạng thái ứng viên
        $applicant = Applicant::find($request->applicant_id);
        if ($applicant && $applicant->status === 'Chờ duyệt') {
            $applicant->status = 'Đã duyệt';
            $applicant->save();
        }
        return redirect()->route('admin.interviews.index')->with('success', '✅ Đã gửi thư mời và lưu vào hệ thống.');
}


    /**
     * Hiển thị danh sách thư mời đã gửi
     */
    public function index()
    {
        $invitations = Interview::orderBy('created_at', 'desc')->get();
        return view('admin.interviews.index', compact('invitations'));
    }

    public function show($id)
    {
        $interview = Interview::findOrFail($id);
        return view('admin.interviews.show', compact('interview'));
    }

    public function edit($id)
    {
        $interview = Interview::findOrFail($id);
        return view('admin.interviews.edit', compact('interview'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name'      => 'required|string|max:255',
            'email'          => 'required|email',
            'position'       => 'required|string|max:255',
            'interview_time' => 'nullable|date',
            'note'           => 'nullable|string',
        ]);

        $interview = Interview::findOrFail($id);
        $interview->update($request->only(['full_name', 'email', 'position', 'interview_time', 'note']));

        return redirect()->route('admin.interviews.index')->with('success', '✅ Đã cập nhật thư mời.');
    }

    public function destroy($id)
    {
        Interview::destroy($id);
        return redirect()->route('admin.interviews.index')->with('success', '🗑️ Đã xoá thư mời.');
    }

    /**
     * Hiển thị form xác nhận phỏng vấn
     */
   public function confirmationForm()
    {
        // Lấy danh sách ứng viên từ bảng interviews đã có status = 'Đã gửi thư mời'
        $candidates = Interview::where('status', 'Đã gửi thư mời')
            ->orderBy('full_name')
            ->get();

        return view('admin.interviews.confirmation', compact('candidates'));
    }


    /**
     * Lưu xác nhận phỏng vấn
     */
    public function submitConfirmation(Request $request)
        {
            $request->validate([
                'full_name'           => 'required|string|max:255',
                'confirmation_status' => 'required|string',
                'note'                => 'nullable|string'
            ]);

            // Tìm bản ghi interview gần nhất theo tên
            $interview = Interview::where('full_name', $request->full_name)->latest()->first();

            if ($interview) {
                $interview->confirmation_status = $request->confirmation_status;
                $interview->note = $request->note;

                if ($request->confirmation_status === 'Đã xác nhận') {
                    $interview->status = 'Đã xác nhận';

                    // Cập nhật trạng thái ứng viên
                    $applicant = Applicant::where('id', $interview->applicant_id)->first();
                    if ($applicant) {
                        $applicant->status = 'Đã duyệt'; // Hoặc giữ nguyên nếu cần
                        $applicant->confirmation = 'Đã đồng ý'; // 🔁 Đây là điều kiện hiển thị ở accepted
                        $applicant->save();
                    }
                }

                $interview->save();
            }
            return redirect()->route('admin.interviews.index')
                ->with('success', '✅ Đã xác nhận phỏng vấn và cập nhật trạng thái ứng viên.');
        }


    /**
     * Cập nhật trạng thái thư mời
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $interview = Interview::findOrFail($id);
        $interview->status = $request->status;
        $interview->save();

        return redirect()->back()->with('success', '✅ Cập nhật trạng thái thành công.');
    }
}
