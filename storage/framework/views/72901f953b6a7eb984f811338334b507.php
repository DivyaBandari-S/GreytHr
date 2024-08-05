<div style="text-align:center">
    <!--[if BLOCK]><![endif]--><?php if(auth()->guard('hr')->check()): ?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin-dashboard');

$__html = app('livewire')->mount($__name, $__params, 'lw-1155904116-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/home-dashboard.blade.php ENDPATH**/ ?>