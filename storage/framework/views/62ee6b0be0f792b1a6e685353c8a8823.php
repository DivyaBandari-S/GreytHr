<div>
    <div class="container mt-5 pt-5">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card" style="height: 70vh;">
                    <div class="card-header">
                        <h5 class="card-title">Image Upload</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 pl-4 pr-4 text-center">
                                <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
                                    <div class="alert alert-success text-center"><?php echo e(session('message')); ?></div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <form wire:submit.prevent="uploadImage">
                                    <div class="form-group">
                                        <label for="image" class="font-weight-bold">Select Image</label>
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <input type="file" class="form-control" wire:model="image" style="padding: 3px 5px;" />
                                            </div>
                                        </div>

                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger" style="font-size: 11.5px;"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->


                                        <div wire:loading wire:target="image" wire:key="image"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i> Uploading</div>


                                        


                                        <!--[if BLOCK]><![endif]--><?php if($image): ?>
                                            <img src="<?php echo e($image->temporaryUrl()); ?>" width="100" alt="" class="mt-2">
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>


                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary w-50 mt-2"><div wire:loading wire:target="uploadImage" wire:key="uploadImage"><i class="fa fa-spinner fa-spin"></i></div> Upload</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8">
                                <div class="card" style="height: 58vh;">
                                    <div class="card-header">All Images</div>
                                    <div class="card-body">
                                        <!--[if BLOCK]><![endif]--><?php if($images->count() > 0): ?>
                                            <div class="row">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-md-2 mb-4">
                                                        <img src="data:image;base64,<?php echo e(base64_encode($image->image)); ?>" width="100" height="100">
                                                        
                                                        

                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        <?php else: ?>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    No Image Found
                                                </div>
                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/image-upload.blade.php ENDPATH**/ ?>