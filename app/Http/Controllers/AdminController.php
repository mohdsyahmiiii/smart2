<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['showLoginForm', 'login']);
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'username' => 'Invalid credentials',
        ]);
    }

    public function dashboard()
    {
        // Get lecturers and students from users table using role filter
        $lecturers = User::where('role', 'lecturer')->get();
        $students = User::where('role', 'student')->get();
        return view('admin.dashboard', compact('lecturers', 'students'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    // Lecturer CRUD
    public function lecturerIndex()
    {
        $lecturers = User::where('role', 'lecturer')->get();
        return view('admin.lecturers.index', compact('lecturers'));
    }

    public function lecturerCreate()
    {
        return view('admin.lecturers.create');
    }

    public function lecturerStore(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);

            $validated['password'] = Hash::make($validated['password']);
            $validated['role'] = 'lecturer';
            
            $lecturer = User::create($validated);

            if ($lecturer) {
                return redirect()->route('admin.lecturers.index')
                    ->with('success', 'Lecturer created successfully');
            } else {
                return back()->withInput()
                    ->with('error', 'Failed to create lecturer');
            }
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error creating lecturer: ' . $e->getMessage());
        }
    }

    public function lecturerEdit(User $lecturer)
    {
        return view('admin.lecturers.edit', compact('lecturer'));
    }

    public function lecturerUpdate(Request $request, User $lecturer)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $lecturer->id,
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $lecturer->update($validated);
        return redirect()->route('admin.lecturers.index')
            ->with('success', 'Lecturer updated successfully');
    }

    public function lecturerDestroy(User $lecturer)
    {
        $lecturer->delete();
        return redirect()->route('admin.lecturers.index')
            ->with('success', 'Lecturer deleted successfully');
    }

    // Student CRUD
    public function studentIndex()
    {
        $students = User::where('role', 'student')->get();
        return view('admin.students.index', compact('students'));
    }

    public function studentCreate()
    {
        return view('admin.students.create');
    }

    public function studentStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'student';
        User::create($validated);

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully');
    }

    public function studentEdit(User $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function studentUpdate(Request $request, User $student)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $student->id,
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $student->update($validated);
        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully');
    }

    public function studentDestroy(User $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully');
    }
} 