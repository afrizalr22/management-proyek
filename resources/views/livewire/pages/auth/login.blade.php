<?php

use App\Livewire\Forms\LoginForm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.login')] class extends Component
{
    public LoginForm $form;

    /**
     * Menangani proses autentikasi pengguna.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $user = Auth::user();

        if (! $user instanceof User) {
            Auth::logout();

            throw ValidationException::withMessages([
                'form.email' => 'Sesi login tidak valid. Silakan coba kembali.',
            ]);
        }

        if ($user->hasRole('owner')) {
            $this->redirectRoute(
                'owner.dashboard',
                navigate: true
            );

            return;
        }

        if ($user->hasRole('mandor')) {
            $this->redirectRoute(
                'mandor.dashboard',
                navigate: true
            );

            return;
        }

        if ($user->hasRole('pekerja')) {
            $this->redirectRoute(
                'pekerja.dashboard',
                navigate: true
            );

            return;
        }

        Auth::logout();

        Session::invalidate();
        Session::regenerateToken();

        throw ValidationException::withMessages([
            'form.email' => 'Akun belum mempunyai role yang valid.',
        ]);
    }
}; ?>

<div class="min-h-screen bg-white lg:grid lg:grid-cols-[1.05fr_0.95fr]">

    {{-- =========================================================
        PANEL KIRI
    ========================================================== --}}
    <section
        class="relative hidden min-h-screen overflow-hidden bg-slate-950 text-white lg:flex lg:flex-col lg:justify-between"
    >
        {{-- Background decoration --}}
        <div
            class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-950 to-blue-950"
        ></div>

        <div
            class="absolute -left-32 top-1/3 h-96 w-96 rounded-full bg-blue-600/10 blur-3xl"
        ></div>

        <div
            class="absolute -right-24 -top-24 h-80 w-80 rounded-full bg-sky-500/10 blur-3xl"
        ></div>

        <div
            class="absolute inset-0 opacity-[0.05]"
            style="
                background-image:
                    linear-gradient(rgba(255,255,255,.08) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px);
                background-size: 48px 48px;
            "
        ></div>

        {{-- Brand --}}
        <div class="relative z-10 flex items-center gap-3 px-10 pt-10 xl:px-14">
            <div
                class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 shadow-lg shadow-blue-950/30"
            >
                <svg
                    class="h-6 w-6"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path
                        d="M4 19V9L12 4L20 9V19H4Z"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M8 19V13H16V19"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>

            <div>
                <p class="text-lg font-bold tracking-tight">
                    PT Satria Cipta Karya
                </p>

                <p class="mt-0.5 text-xs font-medium uppercase tracking-[0.18em] text-slate-400">
                    Sistem Manajemen Proyek
                </p>
            </div>
        </div>

        {{-- Main content --}}
        <div class="relative z-10 px-10 xl:px-14">
            <div class="max-w-xl">
                <div
                    class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-medium text-slate-300"
                >
                    <span class="h-2 w-2 rounded-full bg-blue-400"></span>
                    Manajemen Proyek Terintegrasi
                </div>

                <h1
                    class="max-w-lg text-4xl font-bold leading-[1.12] tracking-tight xl:text-5xl"
                >
                    Kelola Proyek Konstruksi Secara Terpusat.
                </h1>

                <p
                    class="mt-6 max-w-xl text-base leading-7 text-slate-400 xl:text-lg"
                >
                    Monitoring progres pekerjaan, laporan harian,
                    dokumentasi lapangan, serta administrasi proyek
                    dalam satu sistem terintegrasi.
                </p>
            </div>

            {{-- Feature cards --}}
            <div class="mt-10 grid max-w-2xl grid-cols-3 gap-3">
                <div
                    class="rounded-2xl border border-white/10 bg-white/[0.06] p-4 backdrop-blur-sm"
                >
                    <div
                        class="mb-3 flex h-9 w-9 items-center justify-center rounded-lg bg-blue-500/15 text-blue-300"
                    >
                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path d="M4 19V10" />
                            <path d="M10 19V5" />
                            <path d="M16 19V13" />
                            <path d="M22 19H2" />
                        </svg>
                    </div>

                    <p class="text-sm font-semibold text-white">
                        Monitoring Progres
                    </p>

                    <p class="mt-1 text-xs leading-5 text-slate-400">
                        Pantau perkembangan pekerjaan proyek.
                    </p>
                </div>

                <div
                    class="rounded-2xl border border-white/10 bg-white/[0.06] p-4 backdrop-blur-sm"
                >
                    <div
                        class="mb-3 flex h-9 w-9 items-center justify-center rounded-lg bg-blue-500/15 text-blue-300"
                    >
                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path d="M6 3H14L18 7V21H6V3Z" />
                            <path d="M14 3V8H18" />
                            <path d="M9 12H15" />
                            <path d="M9 16H15" />
                        </svg>
                    </div>

                    <p class="text-sm font-semibold text-white">
                        Laporan & Dokumentasi
                    </p>

                    <p class="mt-1 text-xs leading-5 text-slate-400">
                        Kelola laporan dan dokumentasi lapangan.
                    </p>
                </div>

                <div
                    class="rounded-2xl border border-white/10 bg-white/[0.06] p-4 backdrop-blur-sm"
                >
                    <div
                        class="mb-3 flex h-9 w-9 items-center justify-center rounded-lg bg-blue-500/15 text-blue-300"
                    >
                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <rect x="4" y="4" width="16" height="16" rx="2" />
                            <path d="M8 9H16" />
                            <path d="M8 13H16" />
                            <path d="M8 17H12" />
                        </svg>
                    </div>

                    <p class="text-sm font-semibold text-white">
                        Administrasi Proyek
                    </p>

                    <p class="mt-1 text-xs leading-5 text-slate-400">
                        Quotation, invoice, dan surat jalan.
                    </p>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div
            class="relative z-10 flex items-center justify-between px-10 pb-9 text-xs text-slate-500 xl:px-14"
        >
            <span>
                © {{ now()->year }} PT Satria Cipta Karya
            </span>

            <span>
                Sistem Manajemen Proyek
            </span>
        </div>
    </section>


    {{-- =========================================================
        PANEL KANAN / LOGIN
    ========================================================== --}}
    <main
        class="flex min-h-screen items-center justify-center bg-white px-6 py-10 sm:px-10 lg:px-14 xl:px-20"
    >
        <div class="w-full max-w-md">

            {{-- Mobile brand --}}
            <div class="mb-10 flex items-center gap-3 lg:hidden">
                <div
                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-white"
                >
                    <svg
                        class="h-6 w-6"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                    >
                        <path
                            d="M4 19V9L12 4L20 9V19H4Z"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linejoin="round"
                        />
                        <path
                            d="M8 19V13H16V19"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>

                <div>
                    <p class="font-bold text-slate-900">
                        PT Satria Cipta Karya
                    </p>

                    <p class="text-xs font-medium uppercase tracking-wider text-slate-500">
                        Sistem Manajemen Proyek
                    </p>
                </div>
            </div>

            <div class="mb-8">
                <p
                    class="mb-3 text-sm font-semibold uppercase tracking-[0.14em] text-blue-600"
                >
                    Akses Sistem
                </p>

                <h2
                    class="text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl"
                >
                    Masuk ke Sistem
                </h2>

                <p class="mt-3 max-w-sm text-sm leading-6 text-slate-500">
                    Gunakan akun yang telah terdaftar untuk mengakses
                    Sistem Manajemen Proyek.
                </p>
            </div>

            <x-auth-session-status
                class="mb-5"
                :status="session('status')"
            />

            <form
                wire:submit="login"
                class="space-y-5"
            >
                {{-- Email --}}
                <div>
                    <label
                        for="email"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Email
                    </label>

                    <div class="relative">
                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"
                        >
                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                aria-hidden="true"
                            >
                                <rect
                                    x="3"
                                    y="5"
                                    width="18"
                                    height="14"
                                    rx="2"
                                />
                                <path d="M3 7L12 13L21 7" />
                            </svg>
                        </div>

                        <input
                            wire:model="form.email"
                            id="email"
                            name="email"
                            type="email"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Masukkan alamat email"
                            class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-12 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10"
                        />
                    </div>

                    <x-input-error
                        :messages="$errors->get('form.email')"
                        class="mt-2"
                    />
                </div>

                {{-- Password --}}
<div>
    <label
        for="password"
        class="mb-2 block text-sm font-semibold text-slate-700"
    >
        Kata Sandi
    </label>

    <div
        class="relative"
        x-data="{ showPassword: false }"
    >
        <div
            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"
        >
            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                aria-hidden="true"
            >
                <rect
                    x="5"
                    y="10"
                    width="14"
                    height="10"
                    rx="2"
                />
                <path d="M8 10V7A4 4 0 0116 7V10" />
            </svg>
        </div>

        <input
            wire:model="form.password"
            id="password"
            name="password"
            type="password"
            x-bind:type="showPassword ? 'text' : 'password'"
            required
            autocomplete="current-password"
            placeholder="Masukkan kata sandi"
            class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-12 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10"
        />

        <button
            type="button"
            x-on:click="showPassword = ! showPassword"
            class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 transition hover:text-slate-700 focus:outline-none"
            x-bind:aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
        >
            {{-- Eye open --}}
            <svg
                x-show="! showPassword"
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                aria-hidden="true"
            >
                <path
                    d="M2.5 12S6 6.5 12 6.5 21.5 12 21.5 12 18 17.5 12 17.5 2.5 12 2.5 12Z"
                />
                <circle
                    cx="12"
                    cy="12"
                    r="2.5"
                />
            </svg>

            {{-- Eye closed --}}
            <svg
                x-show="showPassword"
                x-cloak
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                aria-hidden="true"
            >
                <path d="M3 3L21 21" />
                <path d="M10.6 6.7A8.9 8.9 0 0112 6.5C18 6.5 21.5 12 21.5 12A15 15 0 0118.9 15.2" />
                <path d="M6.2 6.2C3.9 7.8 2.5 12 2.5 12S6 17.5 12 17.5a8.7 8.7 0 003-.5" />
                <path d="M9.9 9.9A3 3 0 0014.1 14.1" />
            </svg>
        </button>
    </div>

    <x-input-error
        :messages="$errors->get('form.password')"
        class="mt-2"
    />
</div>

                {{-- Remember --}}
                <div>
                    <label
                        for="remember"
                        class="inline-flex cursor-pointer items-center gap-2.5"
                    >
                        <input
                            wire:model="form.remember"
                            id="remember"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                        >

                        <span class="text-sm text-slate-600">
                            Ingat Saya
                        </span>
                    </label>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="login"
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-950 px-5 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span wire:loading.remove wire:target="login">
                        Masuk
                    </span>

                    <span wire:loading wire:target="login">
                        Memproses...
                    </span>

                    <svg
                        wire:loading.remove
                        wire:target="login"
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        aria-hidden="true"
                    >
                        <path d="M5 12H19" />
                        <path d="M13 6L19 12L13 18" />
                    </svg>
                </button>
            </form>

            <div class="mt-9 border-t border-slate-100 pt-6">
                <p class="text-center text-xs leading-5 text-slate-400">
                    Akses sistem hanya diperuntukkan bagi pengguna
                    yang telah terdaftar.
                </p>
            </div>
        </div>
    </main>
</div>
