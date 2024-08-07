<div class=" fixed">
    <div class="grid   w-full border-l" style="contain:content">

      <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('chat.chat-box', ['selectedConversation' => $selectedConversation]);

$__html = app('livewire')->mount($__name, $__params, 'lw-2516330273-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

    </div>


</div>
<?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/chat/chat.blade.php ENDPATH**/ ?>