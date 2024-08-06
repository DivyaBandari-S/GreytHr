<div>
    <!--[if BLOCK]><![endif]--><?php if(auth()->guard('emp')->check()): ?>
    <img  height="50" width="200" src="<?php echo e($employee->company_logo); ?>" alt="">
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <!--[if BLOCK]><![endif]--><?php if(auth()->guard('hr')->check()): ?>
    <img height="50" width="200" src="<?php echo e(optional($hr)->company_logo); ?>" alt="">
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if(auth()->guard('it')->check()): ?>
    <img  height="50" width="200" src="<?php echo e(optional($it)->com->company_logo); ?>" alt="">
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <!--[if BLOCK]><![endif]--><?php if(auth()->guard('finance')->check()): ?>
    <img  height="50" width="200" src="<?php echo e(optional($finance)->com->company_logo); ?>" alt="">
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <!--[if BLOCK]><![endif]--><?php if(auth()->guard('admins')->check()): ?>
    <img  height="50" width="200" src="<?php echo e(optional($admin)->com->company_logo); ?>" alt="">
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/company-logo.blade.php ENDPATH**/ ?>