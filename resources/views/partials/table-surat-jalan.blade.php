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
                            <th>Check Surat Jalan</th>

                            @if(request('loading') == 'true')
                                <th>Check Loading</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp

                    @if(empty($datas))
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                    @else
                        @foreach ($datas as $data )
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $data->tanggal_order }}</td>
                            <td>{{ $data->dn_no }}</td>
                            <td>{{ $data->job_no }}</td>
                            <td>{{ $data->cycle }}</td> {{-- FIX: Added closing </td> here --}}
                            <td>
                                @if ($data->check_sj === null)
                                    <b>Open</b>
                                @elseif ($data->check_sj === 1)
                                    <b style="color: red;">Close</b>
                                @else
                                    <b>Open</b> {{-- Tampilkan status apa adanya jika bukan null, OK, atau NG --}}
                                @endif
                            </td>

                            @if(request('loading') == 'true')
                                <td>
                                    @if ($data->check_loading === null)
                                        <b>Open</b>
                                    @elseif ($data->check_loading === 1)
                                        <b style="color: red;">Close</b>
                                    @else
                                        <b>Open</b> {{-- Tampilkan status apa adanya jika bukan null, OK, atau NG --}}
                                    @endif
                                </td>
                            @endif

                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
