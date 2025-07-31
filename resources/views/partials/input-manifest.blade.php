<form method="POST" id="formManifest">
            @csrf
            <div class="mb-3">
                <label for="inputManifest" class="form-label">Manifest</label>
                <input type="text" name="manifest" id="inputManifest" class="form-control" placeholder="Scan Manifest..." autofocus>
            </div>
        </form>
