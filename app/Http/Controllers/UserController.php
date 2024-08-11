<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Models\Committee;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $committees = Committee::all();

        return view('users.create', compact('roles' , 'committees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:15',
            'committee_id' => 'nullable|exists:committees,id',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            
            
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);
        if ($request->hasFile('image')) {
            Log::info('has image ');
            $imagePath = $request->file('image')->store('staff_images', 'public');
            Log::info('has image ');
            Log::info($imagePath);
            // $data['image'] = $imagePath;
        }else {
            Log::info('No image uploaded.');
        }

        // Create the staff record
        Staff::create([
            'id' => $user->id, // Assuming user ID and staff ID are the same
            'name' => $request->name,
            'phone' => $request->phone ?? null, // Adjust as needed
            'committee_id'=>$request->committee_id,
            'image' => $imagePath ?? 'default-image.jpg', // Set a default image or handle image upload
        ]);


        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
