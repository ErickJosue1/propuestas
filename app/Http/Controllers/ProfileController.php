<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Colony;
use App\Models\User;
use App\Models\Workplace;
use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use PasswordValidationRules;

    protected string $routeName;
    protected string $source;
    /* protected string $module = 'profile'; */
    protected User $model;

    public function __construct()
    {
        $this->routeName = "profile.";
        $this->source    = "Profile/";
        $this->model     = new User();
        /*   $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy']); */
    }
    public function index(Request $request): Response
    {
        $records = $this->model;
        $records = $records->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
            }
        })->paginate(10)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'titulo'          => 'Usuarios',
            'records'        => $records,
            'routeName'      => $this->routeName,
            'loadingResults' => false,
            'search'         => $request->search ?? '',
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Profile/Edit', [
            'roles' => Role::pluck('name'),
            'workplaces' => Workplace::all(),
            'colonies' => Colony::all(),
            'titulo' => 'Agregar Usuario',
            'routeName' => $this->routeName,
            'user' => $user
        ]);
    }

    //assign A role to an user

    public function assignRole(Request $request, $userId)
    {

        $user = User::findOrFail($userId);

        //give

        if (!empty($request->roles)) {
            $user->syncRoles($request->roles);
        }

        if (!empty($request->permissions)) {
            $user->givePermissionTo($request->permissions);
        }

        //Revoke

        if (!empty($request->rRoles)) {
            $user->removeRole($request->rRoles);
        }

        if (!empty($request->rPermissions)) {
            $user->revokePermissionTo($request->rPermissions);
        }


        return redirect()->route("{$this->routeName}index")->with('success', 'Roles y Permisos modificados con éxito!');
    }



    public function store(Request $input)
    {
        Validator::make($input->all(), [
            'curp' => ['required', 'string', 'max:18', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'paternal_surname' => ['required', 'string', 'max:255'],
            'maternal_surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'role' => ['required', 'string',],
            'colony_id' => ['required', 'integer', 'exists:colonies,id'],
            'workplace_id' => ['required', 'integer', 'exists:workplaces,id'],
        ])->validate();

        $user = User::create([
            'curp' => $input['curp'],
            'name' => $input['name'],
            'paternal_surname' => $input['paternal_surname'],
            'maternal_surname' => $input['maternal_surname'],
            'colony_id' => $input['colony_id'],
            'workplace_id' => $input['workplace_id'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ])->assignRole($input['role']);


        return redirect()->route("{$this->routeName}index")->with('success', 'Usuario creado con exito con éxito!');
    }

    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'roles' => Role::pluck('name'),
            'workplaces' => Workplace::all(),
            'colonies' => Colony::all(),
            'titulo' => 'Agregar Usuario',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
