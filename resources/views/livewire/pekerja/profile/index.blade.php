<div class="space-y-6">
    <x-profile.profile-header
        :user="$user"
        role-label="Pekerja"
    />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div>
            <x-profile.profile-card
                :user="$user"
                :photo="$photo"
                :photo-success="$photoSuccess"
                role-label="Pekerja"
                photo-input-id="pekerja-profile-photo"
            />
        </div>

        <div class="space-y-6 xl:col-span-2">
            <x-profile.personal-information
                :user="$user"
                :profile-success="$profileSuccess"
                role-label="Pekerja"
                input-prefix="pekerja"
            />

            {{-- Form bidang pekerjaan dan alamat --}}
            <x-pekerja.profile.worker-information
                :worker-profile-success="$workerProfileSuccess"
            />

            {{-- Informasi proyek aktif --}}
            <x-pekerja.profile.work-information
                :assignment="$primaryAssignment"
            />

            {{-- Form kontak darurat --}}
            <x-pekerja.profile.emergency-contact
                :emergency-contact-success="$emergencyContactSuccess"
            />

            <x-profile.security-password
                :password-success="$passwordSuccess"
                input-prefix="pekerja"
            />
        </div>
    </div>
</div>