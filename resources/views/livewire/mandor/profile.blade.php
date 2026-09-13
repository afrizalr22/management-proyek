<div class="space-y-6">
    <x-profile.profile-header
        :user="$user"
        role-label="Mandor"
    />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div>
            <x-profile.profile-card
                :user="$user"
                :photo="$photo"
                :photo-success="$photoSuccess"
                role-label="Mandor"
                photo-input-id="mandor-profile-photo"
            />
        </div>

        <div class="space-y-6 xl:col-span-2">
            <x-profile.personal-information
                :user="$user"
                :profile-success="$profileSuccess"
                role-label="Mandor"
                input-prefix="mandor"
            />

            <x-profile.security-password
                :password-success="$passwordSuccess"
                input-prefix="mandor"
            />
        </div>
    </div>
</div>