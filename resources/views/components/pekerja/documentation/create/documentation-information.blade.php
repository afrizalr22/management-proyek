<div class="grid min-w-0 grid-cols-1 gap-4 md:grid-cols-2">
    {{-- Pilih tugas --}}
    <div class="min-w-0">
        <label
            for="taskId"
            class="mb-2 block text-sm font-semibold text-slate-700"
        >
            Pilih Tugas
            <span class="text-red-500">*</span>
        </label>

        <select
            id="taskId"
            name="taskId"
            class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
        >
            <option value="">Pilih tugas</option>
            <option value="1">Pemasangan Bekisting Kolom</option>
            <option value="2">Pengecekan Material Besi</option>
            <option value="3">Pembersihan Area Pekerjaan</option>
            <option value="4">Pemasangan Tulangan Balok</option>
            <option value="5">Pemeriksaan Alat Keselamatan</option>
        </select>
    </div>

    {{-- Kategori --}}
    <div class="min-w-0">
        <label
            for="documentationCategory"
            class="mb-2 block text-sm font-semibold text-slate-700"
        >
            Kategori Dokumentasi
            <span class="text-red-500">*</span>
        </label>

        <select
            id="documentationCategory"
            name="documentationCategory"
            class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
        >
            <option value="">Pilih kategori</option>
            <option value="progress">Progres</option>
            <option value="material">Material</option>
            <option value="safety">Keselamatan</option>
            <option value="issue">Kendala</option>
        </select>
    </div>

    {{-- Proyek --}}
    <div class="min-w-0">
        <label
            for="projectName"
            class="mb-2 block text-sm font-semibold text-slate-700"
        >
            Proyek
        </label>

        <input
            id="projectName"
            type="text"
            value="Proyek Gedung Perkantoran"
            readonly
            class="block min-h-11 w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-600 outline-none"
        >
    </div>

    {{-- Lokasi --}}
    <div class="min-w-0">
        <label
            for="taskLocation"
            class="mb-2 block text-sm font-semibold text-slate-700"
        >
            Lokasi
        </label>

        <input
            id="taskLocation"
            type="text"
            value="Lantai 2, Zona A"
            readonly
            class="block min-h-11 w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-600 outline-none"
        >
    </div>

    {{-- Keterangan --}}
    <div class="min-w-0 md:col-span-2">
        <label
            for="documentationDescription"
            class="mb-2 block text-sm font-semibold text-slate-700"
        >
            Keterangan Lapangan
            <span class="text-red-500">*</span>
        </label>

        <textarea
            id="documentationDescription"
            name="documentationDescription"
            rows="3"
            maxlength="1000"
            placeholder="Tuliskan kondisi dan hasil pekerjaan..."
            class="block w-full resize-none rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
        ></textarea>

        <p class="mt-2 text-xs text-slate-500">
            Maksimal 1.000 karakter.
        </p>
    </div>
</div>