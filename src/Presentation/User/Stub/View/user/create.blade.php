@extends($lp['directory'] . '.' . $lp['theme'] . '.master')

@section('header')
    @parent
@endsection

@section('breadcrumb')
    @include($lp['directory'] . '.' . $lp['theme'] . '.layouts.breadcrumb', [
        'title' => __('Create a new user'),
        'lists' => [
            [
                'link' => '#',
                'name' => $lp['name'],
            ],
            [
                'link' => 'lp.admin.user.index',
                'name' => __('Users'),
            ],
            [
                'link' => '#',
                'name' => __('New user'),
            ],
        ],
    ])
@endsection

@section('content')
    <form class="forms-sample" method="POST" action="{{ route('lp.admin.user.store') }}">
        @csrf

        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="first_name">{{ __('First Name') }}</label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control"
                                    id="first_name" placeholder="First Name like: Mekaeil">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="last_name">{{ __('Last Name') }}</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control"
                                    id="last_name" placeholder="Last Name like: Andisheh">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="guard_name">{{ __('Groups') }}</label>
                                <select multiple class="form-control" name="groups[]" id="group_name">
                                    <option></option>
                                    @forelse ($groups as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                    id="email" placeholder="example@weprodev.com">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="mobile">{{ __('Mobile') }}</label>
                                <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control"
                                    id="mobile" placeholder="Mobile number like: 031687xxxxxxxx">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="pending">pending</option>
                                    <option value="accepted">accepted</option>
                                    <option value="blocked">blocked</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input type="text" name="password" class="form-control" id="password"
                                    placeholder="Min character is 6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Roles') }}</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                @forelse ($roles as $item)
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="roles[]" value="{{ $item->name }}"
                                                class="form-check-input">
                                            {{ $item->title . ($item->description ? '  [ ' . $item->description . ' ]' : '') }}
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                @empty
                                    ----
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 grid-margin stretch-card">
            <button type="submit" class="btn btn-gradient-primary mr-2">{{ __('Submit') }}</button>
            <a href="{{ route('lp.admin.user.index') }}" class="btn btn-light">{{ __('Cancel') }}</a>
        </div>
    </form>
@endsection


@section('footer')
    @parent
@endsection
