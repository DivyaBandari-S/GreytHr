<div class=" fixed ">

    <div class="hidden lg:flex relative " >
        <livewire:chat.chat-list :selectedConversation="$selectedConversation" :query="$query">
    </div>

    <div class="grid   w-full border-l" style="contain:content">

      <livewire:chat.chat-box :selectedConversation="$selectedConversation">

    </div>


</div>
