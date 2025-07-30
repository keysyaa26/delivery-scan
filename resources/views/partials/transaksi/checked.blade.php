
    <div class="table-responsive-scroll">
        <table class="table table-bordered table-striped mt-2 table-hover table-sm text-center">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Customer</th>
                    <th>Tanggal</th>
                    <th>Manifest</th>
                    <th>Job No</th>
                    <th>Cycle</th>
                    <th>Part No.</th>
                    <th>Total Qty Pcs</th>
                    <th>Qty Kanban</th>
                    <th>Proses Scan</th>
                    <th>Status Label</th>
                    <th>Scan Leader</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp

                @if(empty($data))
                    <tr>
                        <td colspan="12" class="text-center">Tidak ada data</td>
                    </tr>
                @else
                    @foreach ($data as $d )
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$d->customer}}</td>
                        <td>{{$d->tanggal_order}}</td>
                        <td>{{$d->dn_no}}</td>
                        <td>{{$d->job_no}}</td>
                        <td>{{$d->cycle}}</td>
                        <td>{{$d->customerpart_no}}</td>
                        <td>{{$d->qty_pcs}}</td>
                        <td>{{$d->QtyPerKbn}}</td>
                        <td>{{$d->countP}}</td>
                        <td>{{$d->status_label}}</td>
                        @if($d->check_leader === null)
                            <td><b>Open</b></td>
                        @elseif($d->check_leader === 1)
                            <td><b>Close</b></td>
                        @endif
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
