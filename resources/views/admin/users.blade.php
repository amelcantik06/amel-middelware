@extends('layouts.app')

@section('title', 'Pengguna')
@section('section', 'Administrasi · Pengguna')

@section('content')
    <div class="page-heading">
        <div><p class="eyebrow">Administrasi</p><h1>Pengguna & akses</h1><p class="subheading">Atur akun admin dan kasir. Password baru hanya diisi bila ingin mengganti.</p></div>
    </div>
    <section class="content-grid" style="grid-template-columns:minmax(280px,.72fr) minmax(0,1.28fr);align-items:start">
        <article class="card">
            <div class="card-heading"><div><h2>Tambah pengguna</h2><p>Akun dapat digunakan segera setelah dibuat.</p></div></div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="form-field"><label for="new-name">Nama</label><input id="new-name" name="name" maxlength="255" required value="{{ old('name') }}"></div>
                <div class="form-field" style="margin-top:13px"><label for="new-email">Email</label><input id="new-email" name="email" type="email" maxlength="255" required value="{{ old('email') }}"></div>
                <div class="form-field" style="margin-top:13px"><label for="new-role">Peran</label><select id="new-role" name="role" required><option value="kasir">Kasir</option><option value="admin">Admin</option></select></div>
                <div class="form-field" style="margin-top:13px"><label for="new-password">Password sementara</label><input id="new-password" name="password" type="password" minlength="8" required autocomplete="new-password"><span class="cell-muted">Minimal 8 karakter; sampaikan secara aman kepada pengguna.</span></div>
                <button class="button" type="submit" style="width:100%;margin-top:17px">Buat pengguna</button>
            </form>
        </article>
        <article class="card">
            <div class="card-heading"><div><h2>Daftar pengguna</h2><p>{{ $users->total() }} akun terdaftar.</p></div></div>
            <div class="table-wrap"><table>
                <thead><tr><th>Nama & email</th><th>Peran</th><th>Ubah akun</th><th></th></tr></thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }} @if($user->is(auth()->user()))<span class="badge">Anda</span>@endif</strong><div class="cell-muted">{{ $user->email }}</div></td>
                        <td><span class="badge {{ $user->role === 'admin' ? '' : 'warning' }}">{{ ucfirst($user->role) }}</span></td>
                        <td style="min-width:210px">
                            <form action="{{ route('admin.users.update', $user) }}" method="POST" style="display:grid;gap:7px">
                                @csrf @method('PUT')
                                <input class="input" name="name" value="{{ $user->name }}" maxlength="255" aria-label="Nama" required>
                                <input class="input" name="email" type="email" value="{{ $user->email }}" aria-label="Email" required>
                                <select class="input" name="role" aria-label="Peran">
                                    <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                    <option value="kasir" @selected($user->role === 'kasir')>Kasir</option>
                                </select>
                                <input class="input" name="password" type="password" minlength="8" autocomplete="new-password" placeholder="Kosongkan jika tetap" aria-label="Password baru">
                                <button class="button secondary small" type="submit">Simpan perubahan</button>
                            </form>
                        </td>
                        <td>
                            @if(!$user->is(auth()->user()))
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus akun {{ addslashes($user->name) }}? Riwayat transaksi tetap ada.')">
                                    @csrf @method('DELETE')<button class="button danger small" type="submit">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty<tr><td colspan="4"><div class="empty-state">Belum ada pengguna.</div></td></tr>@endforelse
                </tbody>
            </table></div>
            @if($users->hasPages())<div class="pagination">{{ $users->links() }}</div>@endif
        </article>
    </section>
@endsection
