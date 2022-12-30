<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>data mahasiswa</span>
                        </a>
                        <div class="pull-right">
                            @if (auth()->user()->hasTeamPermission($curteam, request()->route()->getName().':create'))
                            @if (!$form && !$modal)
                            <button class="btn btn-danger btn-sm" wire:click="toggleForm(false)"><i
                                    class="fas fa-times"></i> Cancel</button>
                            @else
                            <button class="btn btn-primary btn-sm"
                                wire:click="{{$modal ? 'showModal' : 'toggleForm(true)'}}"><i class="fas fa-plus"></i>
                                Add
                                New</button>
                            @endif
                            @endif
                        </div>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <livewire:table.data-mahasiswa-table params="{{request()->route()->getName()}}" />
        </div>

        {{-- Modal form --}}
        <div id="form-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
            aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-capitalize" id="my-modal-title">{{$update_mode ? 'Update' :
                            'Tambah'}} data mahasiswa</h5>
                    </div>
                    <div class="modal-body">
                        <x-text-field type="text" name="nama_mahasiswa" label="Nama Mahasiswa" />
                        <x-text-field type="text" name="kode_mahasiswa" label="NIM" />
                        <x-select name="data_prodi_id" label="Pilih Prodi">
                            <option value="">Select Prodi</option>
                            @foreach ($prodies as $prodi)
                            <option value="{{$prodi->id}}">{{$prodi->kode_prodi}} - {{$prodi->nama_prodi}}</option>
                            @endforeach
                        </x-select>
                        <x-select name="kelas_id" label="Pilih Kelas">
                            <option value="">Select Kelas</option>
                            @foreach ($kelass as $kelas)
                            <option value="{{$kelas->id}}">{{$kelas->kode_kelas}} - {{$kelas->nama_kelas}}</option>
                            @endforeach
                        </x-select>
                        <x-select name="data_semester_id" label="Pilih Semester">
                            <option value="">Pilih Semester</option>
                            @foreach ($semesters as $semester)
                            <option value="{{$semester->id}}">{{$semester->kode_semester}} -
                                {{$semester->nama_semester}}</option>
                            @endforeach
                        </x-select>

                        <x-text-field type="number" name="telepon_mahasiswa" label="Telepon Mahasiswa" />
                        <x-textarea type="text" name="alamat_mahasiswa" label="Alamat Mahasiswa" />
                    </div>
                    <div class="modal-footer">

                        <button type="button" wire:click={{$update_mode ? 'update' : 'store' }}
                            class="btn btn-primary btn-sm"><i class="fa fa-check pr-2"></i>Simpan</button>

                        <button class="btn btn-danger btn-sm" wire:click='_reset'><i
                                class="fa fa-times pr-2"></i>Batal</a>

                    </div>
                </div>
            </div>
        </div>


        {{-- Modal confirm --}}
        <div id="confirm-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
            aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Konfirmasi Hapus</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin hapus data ini.?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" wire:click='delete' class="btn btn-danger btn-sm"><i
                                class="fa fa-check pr-2"></i>Ya, Hapus</button>
                        <button class="btn btn-primary btn-sm" wire:click='_reset'><i
                                class="fa fa-times pr-2"></i>Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')



    <script>
        document.addEventListener('livewire:load', function(e) {
             window.livewire.on('loadForm', (data) => {
                
                
            });
            window.livewire.on('showModal', (data) => {
                $('#form-modal').modal('show')
            });

            window.livewire.on('closeModal', (data) => {
                $('#confirm-modal').modal('hide')
                $('#form-modal').modal('hide')
            });
        })
    </script>
    @endpush
</div>