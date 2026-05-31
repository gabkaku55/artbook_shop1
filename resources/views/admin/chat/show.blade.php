@extends('admin.dashboard')

@section('admin_content')
<div class="mb-12 flex justify-between items-center">
    <div class="flex items-center">
        <a href="{{ route('admin.chat.index') }}" class="w-12 h-12 bg-gray-800 rounded-2xl flex items-center justify-center mr-6 text-gray-400 hover:text-white transition border border-gray-700">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-3xl font-black text-white uppercase tracking-tighter">{{ $user->name }}</h2>
            <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">{{ $user->email }}</p>
        </div>
    </div>
</div>

<div class="bg-gray-900 rounded-[2.5rem] border border-gray-800 shadow-2xl overflow-hidden flex flex-col h-[600px]">
    <div class="flex-grow overflow-y-auto p-10 space-y-6" id="admin-messages-container">
        @foreach($messages as $message)
            <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }} items-end gap-4">
                @if($message->sender_id != auth()->id())
                    <div class="w-12 h-12 rounded-2xl overflow-hidden flex-shrink-0 border border-gray-700 shadow-sm">
                        @if($message->sender->avatar)
                            <img src="{{ asset('storage/' . $message->sender->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-800 flex items-center justify-center text-gray-400 font-bold text-lg">
                                ?
                            </div>
                        @endif
                    </div>
                @endif
                <div class="max-w-[70%] {{ $message->sender_id == auth()->id() ? 'bg-indigo-600 text-white rounded-l-3xl rounded-tr-3xl' : 'bg-gray-800 text-gray-200 rounded-r-3xl rounded-tl-3xl border border-gray-700' }} p-6 shadow-lg">
                    <p class="text-sm leading-relaxed">{{ $message->content }}</p>
                    <span class="text-[9px] font-black opacity-50 block mt-2 uppercase tracking-widest">{{ $message->created_at->format('d.m H:i') }}</span>
                </div>
                @if($message->sender_id == auth()->id())
                    <div class="w-12 h-12 rounded-2xl overflow-hidden flex-shrink-0 border border-indigo-500/20 shadow-sm">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-indigo-600 flex items-center justify-center text-white font-bold text-lg">
                                ?
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="p-8 border-t border-gray-800 bg-gray-800/20">
        <form action="{{ route('admin.chat.store', $user->id) }}" method="POST" class="flex gap-4">
            @csrf
            <input type="text" name="content" required placeholder="Напишіть відповідь..." class="flex-grow bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition border">
            <button type="submit" class="bg-indigo-600 text-white w-14 h-14 rounded-2xl flex items-center justify-center hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/20">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<script>
    const container = document.getElementById('admin-messages-container');
    container.scrollTop = container.scrollHeight;
</script>
@endsection
