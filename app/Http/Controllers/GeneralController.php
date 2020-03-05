<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\ExpenseCategory;
use App\Models\Expense;

use Auth;

use Illuminate\Support\Facades\Validator;

class GeneralController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard');
    }

    public function rolesView()
    {
        return view('roles');
    }

    public function fetchRoles() 
    {
        $roles = Role::paginate(10);
        return $roles;
    }
    
    public function addRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }
        $role = new Role;
        $role->name = ucwords($request->name);
        $role->description = ucwords($request->description);
        $role->save();
        return response()->json(['status' => 'success', 'message' => 'Role added']);
    }

    public function updateRole(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'name' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }
        $role = Role::find($request->role_id);
        $role->name = ucwords($request->name);
        $role->description = ucwords($request->description);
        $role->save();
        return response()->json(['status' => 'success', 'message' => 'Role updated']);
    }

    public function deleteRole($role_id)
    {
        $role = Role::find($role_id);
        $role->delete();
        return response()->json(['status' => 'success', 'message' => 'Role deleted']);
    }

    public function usersView()
    {
        return view('users');
    }

    public function fetchUsers()
    {
        $users = User::leftJoin('roles', 'users.role_id', '=', 'roles.id')
                ->select('users.*', 'roles.name as role_name')
                ->orderBy('users.role_id', 'asc')
                ->get();
        return $users;
    }

    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required'    
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }
        $user = new User;
        $user->name = ucwords($request->name);
        $user->email = $request->email;
        $user->password = bcrypt($request->email);
        $user->role_id = $request->role;
        $user->save();
        return response()->json(['status' => 'success', 'message' => 'User added']);
    }

    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required'   
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }
        $user = User::find($request->user_id);
        if($user->name !== $request->name){
            $user->name = ucwords($request->name);
        }
        if($user->email !== $request->email){
            $user->email = $request->email;
        }
        if(!\Hash::check($request->password, $user->password)){
            $user->password = bcrypt($request->email);
        }
        if($user->role_id!==$request->role){
            $user->role_id = $request->role;
        }
        $user->save();
        return response()->json(['status' => 'success', 'message' => 'User added']);
    }

    public function deleteUser($user_id)
    {
        $user = User::find($user_id);
        $user->delete();
        return response()->json(['status' => 'success', 'message' => 'User deleted']);
    }

    public function categoriesView()
    {
        return view('categories');
    }

    public function fetchCategories()
    {
        $categories = ExpenseCategory::get();
        return $categories;
    }

    public function addCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }
        $category = new ExpenseCategory;
        $category->name = ucwords($request->name);
        $category->description = ucwords($request->description);
        $category->save();
        return response()->json(['status' => 'success', 'message' => 'Category added']);
    }   

    public function updateCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }
        $category = ExpenseCategory::find($request->category_id);
        $category->name = ucwords($request->name);
        $category->description = ucwords($request->description);
        $category->save();
        return response()->json(['status' => 'success', 'message' => 'Category updated']);
    }

    public function deleteCategory($category_id)
    {
        $category = ExpenseCategory::find($category_id);
        $category->delete();
        return response()->json(['status' => 'success', 'message' => 'Category deleted']);
    }

    public function expensesView()
    {
        return view('expenses');
    }

    public function fetchExpenses()
    {
        $expenses = Expense::where('user_id', Auth::user()->id)
                ->leftJoin('expense_categories', 'expense_categories.id', 'expenses.category_id')
                ->select('expenses.*', 'expense_categories.name as category_name')
                ->orderBy('expenses.entry_date', 'desc')
                ->get();
        return $expenses;
    }

    public function addExpense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }
        $expense = new Expense;
        $expense->category_id = $request->category;
        $expense->amount = $request->amount;
        $expense->entry_date = $request->date;
        $expense->user_id = Auth::user()->id;
        $expense->save();
        return response()->json(['status' => 'success', 'message' => 'User added']);
    }

    public function updateExpense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'expense_id' => 'required',
            'category' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }
        $expense = Expense::find($request->expense_id);
        $expense->category_id = $request->category;
        $expense->amount = $request->amount;
        $expense->entry_date = $request->date;
        $expense->save();
        return response()->json(['status' => 'success', 'message' => 'Expense added']);
    }

    public function deleteExpense($expense_id)
    {
        $expense = Expense::find($expense_id);
        $expense->delete();
        return response()->json(['status' => 'success', 'message' => 'Expense deleted']);
    }   

    public function fetchHelperRoles() 
    {
        $roles = Role::get();
        return $roles;
    }

    public function fetchHelperCategories()
    {
        $categories = ExpenseCategory::get();
        return $categories;
    }

    public function fetchDashboardData()
    {
        $expense = Expense::where('user_id', Auth::user()->id)
        ->leftJoin('expense_categories', 'expenses.category_id', 'expense_categories.id')
        ->select('expenses.*', 'expense_categories.name as category_name')
        ->get();
        return $expense;
    }
}
