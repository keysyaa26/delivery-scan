<form id="formParts">
            @csrf
            <div class="mb-3">
                <label for="inputParts" class="form-label">Label Customer</label>
                <input type="text" name="parts" id="inputParts" class="form-control" value="{{old('parts')}}" placeholder="Scan Label Customer..." autofocus>
            </div>
        </form>
