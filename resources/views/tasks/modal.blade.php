<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
    
            <!-- Input title -->
            <div class="form-group mb-2">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="description">Descripción</label>
                <textarea class="form-control" name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">
                {{ old('description') }}
                </textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="expirated_at">Fecha caducidad</label>
                <input type="text" name="expirated_at" id="expirated_at" class="form-control @error('expirated_at') is-invalid @enderror" placeholder="ejemplo: 2023-11-11" value="{{ old('expirated_at') }}" autofocus>
                @error('expirated_at')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="user_id">Usuario</label>
                <select class="js-example-basic-single form-control" name="user_id" id="user_id">
                    <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
                </select>
                @error('user_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="tags">Etiquetas</label>
                <select class="form-control tags @error('tags') is-invalid @enderror" name="tags[]" id="tags" multiple="multiple"></select>
                @error('tags')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>
        <div class="modal-footer"></div>
    </div>

</div>