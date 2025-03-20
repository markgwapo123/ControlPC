<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TargetPC;

class TargetPCController extends Controller
{
    public function addPC(Request $request)
    {
        try {
            $request->validate([
                'ip' => 'required|ip|unique:target_pcs,ip',
            ]);

            $pc = TargetPC::create([
                'ip' => $request->ip,
                'status' => 'pending',
            ]);

            return response()->json(['message' => 'PC added successfully', 'data' => $pc], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function checkAndControl(Request $request)
    {
        try {
            $request->validate([
                'ip' => 'required|ip|exists:target_pcs,ip',
            ]);

            // Get the PC record
            $pc = TargetPC::where('ip', $request->ip)->first();

            // Ping Command (Windows: -n 1, Linux: -c 1)
            $pingCommand = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'
                ? "ping -n 1 " . escapeshellarg($pc->ip)
                : "ping -c 1 " . escapeshellarg($pc->ip);

            $pingResult = shell_exec($pingCommand);

            // Check response
            if (preg_match('/Reply from|bytes from/', $pingResult)) {
                $status = 'connected';

                // 🔹 If online, execute PsExec to shutdown automatically
                $shutdownCommand = "C:\\path\\to\\PsExec.exe \\\\" . $pc->ip . 
                                   " -u Administrator -p YourPassword shutdown /s /t 0";
                shell_exec($shutdownCommand);
            } else {
                $status = 'failed';
            }

            // Update database
            $pc->update(['status' => $status]);

            return response()->json([
                'message' => 'PC status checked',
                'data' => $pc
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function dashboard()
{
    $pcs = TargetPC::all();
    return view('dashboard', compact('pcs'));
}

}
