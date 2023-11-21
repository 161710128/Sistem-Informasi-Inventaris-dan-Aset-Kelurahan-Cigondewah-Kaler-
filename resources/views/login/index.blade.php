@extends('layouts.main')
<div class="row justify-content-center ">
    <div class="col-lg-5">

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        @endif

        <main class="form-signin w-100 m-auto" style="padding:70px">
            <h1 class="h1 mb-1 fw-normal text-center text-shadow-yellow"><b> Sistem Informasi Inventaris dan Aset</b></h1>
            <h3 class="h4 mb-3 fw-normal text-center text-shadow-yellow"><i> Silakan login</i></h3>

            <form action="/login" method="post">
                @csrf
                <div class="form-floating">
                    <input type="email" name="email" class="form-control" id="email"  placeholder="name@example.com" autofocus required value="{{ @old('email') }}" @error ('email')is-invalid @enderror>
                    <label for="email" >Email address</label>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $error }}
                        </div>                    
                    @enderror
                </div>
                <div class="form-floating">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                    <label for="password">Password</label>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>                    
                    @enderror
                </div>
                <div class="form-floating">
                    <select  type="role" name="role" class="form-select" id="role" placeholder="role" style="font-size: 0.875rem;" required>
                       <option selected><label for="role">Role</label></option>
                        <option value="admin">Admin</option>
                        <option value="lurah">Lurah</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>                    
                    @enderror
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">login</button>
            </form>
        </main>
        
    </div>
</div>
