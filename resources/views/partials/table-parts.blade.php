<h4 class="mb-4">Data Parts</h4>
            <div class="table-responsive-scroll">
                <table class="table table-bordered table-striped mt-2 table-hover table-sm text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Manifest</th>
                            <th>Job No</th>
                            <th>Inv ID</th>
                            <th>Part Name</th>
                            <th>Status by Member</th>
                            <th>Status by Leader</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $i = 1;
                    @endphp

                    @if(empty($dataParts))
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                    @else
                        @foreach ($dataParts as $part )
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $part->dn_no }}</td>
                            <td>{{ $part->job_no }}</td>
                            <td>{{ $part->InvId }}</td> {{-- FIX: Added closing </td> here --}}
                            <td>{{ $part->PartName }}</td>
                            <td>tes</td>
                            <td>tes</td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
