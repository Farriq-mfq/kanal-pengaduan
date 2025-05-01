@foreach ($role->permissions as $permission)
    <span class="badge bg-primary">
        {{$permission->name}}
    </span>
@endforeach
