<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>form jadwal</span>
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
            <livewire:table.form-jadwal-table params="{{request()->route()->getName()}}" />
        </div>

        {{-- Modal form --}}
        <div id="form-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
            aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-capitalize" id="my-modal-title">{{$update_mode ? 'Update' :
                            'Tambah'}} form jadwal</h5>
                    </div>
                    <div class="modal-body">
                        @if (Auth::user()->role->role_type == 'dosen')

                        <x-select name="hari_perubahan" label="Hari Perubahan">
                            <option value="">Select Hari Perubahan</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="jum'at">jum'at</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </x-select>
                        <x-text-field type="time" name="jam_perubahan" label="Jam Perubahan" />

                        <x-select name="data_kelas_id" label="Pilih Kelas">
                            <option value="">Select Kelas</option>
                            @foreach ($kelass as $kelas)
                            <option value="{{$kelas->id}}">{{$kelas->kode_kelas}} - {{$kelas->nama_kelas}}</option>
                            @endforeach
                        </x-select>
                        <x-select name="data_jadwal_id" label="Jadwal">
                            <option value="">Select Jadwal</option>
                            @foreach ($jadwals as $jadwal)
                            <option value="{{$jadwal->id}}">{{$jadwal->hari_jadwal}} - {{$jadwal->waktu_jadwal}}
                            </option>
                            @endforeach
                        </x-select>

                        <x-textarea type="textarea" name="alasan_perubahan" label="Alasan Perubahan" />
                        @endif

                        @if (in_array(Auth::user()->role->role_type, ['superadmin','admin']))
                        <x-select name="status" label="Status">
                            <option value="">Select Status</option>
                            <option value="1">Disetujui</option>
                            <option value="2">Ditolak</option>
                        </x-select>
                        @if ($status == 2)
                        <x-textarea type="textarea" name="keterangan" label="Alasan Tolak" />
                        @endif
                        @endif
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