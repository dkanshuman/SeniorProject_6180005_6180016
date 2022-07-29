
<div class="modal-container" id="table-block">
    <div class="modal">
        <div class="over-card" >
            <div class="close-block">
                <a class="icon-btn" href="javascript:void(0)" onclick="closeEditorForm('table-block')"  id="close-img-block"><i class="fa-solid fa-xmark"></i></a>
            </div>
            <form id="loadTableForm">
                <h2 class="sub-heading">Create Table</h2>

                <input type="hidden" name="" id="table-editor">
                <input type="hidden" name="" id="table-content">
                
                <div class="form-block">
                    <label for="cols" class="form-label">Columns<span class="text-red">*</span></label>
                    <input type="number" name="cols" id="cols" required placeholder="Enter number of columns" class="form-control">
                </div>

                <div class="form-block">
                    <label for="rows" class="form-label">Rows<span class="text-red">*</span></label>
                    <input type="number" name="rows" id="rows" required placeholder="Enter number of rows" class="form-control">
                </div>

                <div class="form-block">
                    <label for="caption" class="form-label">Caption (if any)</label>
                    <input type="text" name="caption" id="caption" required placeholder="Enter Caption" class="form-control">
                </div>

                <div class="form-block">
                    <input type="checkbox" name="header" id="header" value="yes" checked> <label for="header">Add Header Row</label>
                </div>

                <div class="form-block">
                    <button class="btn btn-green">Create Table</button>
                </div>
            </form>
        </div>
    </div>
</div>

    
<div class="modal-container" id="upload-block">
    <div class="modal">       
        <div class="over-card">
            <div class="close-block">
                <a class="icon-btn" href="javascript:void(0)" onclick="closeEditorForm('upload-block')"  id="close-img-block"><i class="fa-solid fa-xmark"></i></a>
            </div>
            <form id="imgForm">
                <h2 class="sub-heading">Upload Image</h2>
                <input type="hidden" name="" id="upload-editor">
                <input type="hidden" name="" id="upload-content">
                <div class="form-block">
                    <input type="file" id="fileimg" accept="image/png, image/jpg, image/jpeg" required>
                </div>
                <div class="form-block">
                    <button class="btn btn-green">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal-container" id="resize-block">
    <div class="modal">
        <div class="over-card" >
            <div class="close-block">
                <a class="icon-btn" href="javascript:void(0)" onclick="closeEditorForm('resize-block')"  id="close-img-block"><i class="fa-solid fa-xmark"></i></a>
            </div>
            <form id="resizeForm">
                <h2 class="sub-heading">Resize Dimensions</h2>

                <input type="hidden" name="" id="image-editor">
                <input type="hidden" name="" id="old-image-name">
                
                <div class="form-block">
                    <label for="width" class="form-label">Width<span class="text-red">*</span></label>
                    <input type="number" name="width" id="resize-width" required placeholder="Enter number of Width" class="form-control" onblur="changeHeight(this.value)">
                    <input type="hidden" name="" id="old-resize-width">
                </div>

                <div class="form-block">
                    <label for="height" class="form-label">Height<span class="text-red">*</span></label>
                    <input type="number" name="height" id="resize-height" required placeholder="Enter number of height" class="form-control" onblur="changeWidth(this.value)">
                    <input type="hidden" name="" id="old-resize-height">
                </div>

                <div class="form-block">
                    <input type="hidden" name="quality" id="resize-quality" required placeholder="Enter number of quality" class="form-control" value="100">
                </div>

                <div class="form-block">
                    <button class="btn btn-green">Resize</button>
                </div>
            </form>
        </div>
    </div>
</div>