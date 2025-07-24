<h4 class="mb-4">Data Manifest</h4>
            <div class="table-responsive-scroll">
                <table class="table table-bordered table-striped mt-2 table-hover table-sm text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Order</th>
                            <th>Manifest</th>
                            <th>Job No</th>
                            <th>Cycle</th>
                            @if(in_array(Illuminate\Support\Facades\Auth::user()->id_role, [1, 2]))
                                <th>Scan by Admin</th>
                            @else
                                <th>Status</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp

                    @if(empty($manifests))
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                    @else
                        @foreach ($manifests as $manifest )
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $manifest->tanggal_order }}</td>
                            <td>{{ $manifest->dn_no }}</td>
                            <td>{{ $manifest->job_no }}</td>
                            <td>{{ $manifest->cycle }}</td> {{-- FIX: Added closing </td> here --}}
                            <td>
                                @if ($manifest->status === null)
                                    <b>Open</b>
                                @elseif ($manifest->status === 'OK')
                                    <b style="color: red;">Close</b>
                                @else
                                    {{ $item->status }} {{-- Tampilkan status apa adanya jika bukan null, OK, atau NG --}}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
