  <div class="modal fade" id="collectionModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content shadow border-0 border-radius-0" style="background: none;min-height: 250px;min-width:568px;">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" onclick="$('#collectionModal').modal('hide')"></button>
                    </div>
                    <div class="modal-body  bg-white p-5" style="padding-top:1rem!important;" >
                        <h4 style="font-size: 16px;font-weight: 700;font-family: system-ui;">
                            <span style="vertical-align: -webkit-baseline-middle;">Save to Collection</span>

                            <div class="float-right position-relative">
                                <button onclick="createC()" class=" rd__button--compact rd__button--white listDrop">Create Collection</button>

                                <ul class="position-absolute dropCollection shadow p-4" style="z-index: 1050;min-width:230px;background: white;right: -50px;display:none;">
                                    <h6 style="font-size: 14px;font-weight: 700;font-family: system-ui;">Title</h6>
                                    <input type="text" id="createCollectionInput" class="form-control">
                                    <button data-id="" id="createCollectionButton" class="btn btn-primary btn-sm float-end mt-4">Create Collection</button>

                                </ul>
                            </div>

                        </h4>

                        <ul id="CollectionsList" style="padding-left:0;">



                        </ul>


                    </div>
                    <div class="bg-white p-4">
                        <a class="link text-decoration-underline link-dark d-block" href="#">View your Collections...</a>
                    </div>
                </div>
            </div>
        </div>

