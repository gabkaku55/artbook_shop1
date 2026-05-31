@extends('layouts.app')

@section('content')
<div class="page-chat py-12 bg-gray-950 min-h-screen flex items-center justify-center">
    <div class="max-w-4xl w-full px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-900 rounded-[2.5rem] border border-gray-800 shadow-2xl overflow-hidden flex flex-col h-[700px]">
            <div class="p-8 border-b border-gray-800 bg-gray-800/30 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-indigo-500/20">
                        <i class="fas fa-headset text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-white uppercase tracking-tighter">{{ __('messages.chat_support') }}</h2>
                        <div class="flex items-center mt-1">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">{{ __('messages.admin_online') }}</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-white transition">
                    <i class="fas fa-times text-xl"></i>
                </a>
            </div>

            <div class="flex-grow overflow-y-auto p-8 space-y-6" id="messages-container">
                @if($messages->isEmpty())
                    <div class="h-full flex flex-col items-center justify-center text-center space-y-4">
                        <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center text-gray-600 border border-gray-700">
                            <i class="fas fa-comments text-3xl"></i>
                        </div>
                        <div>
                            <p class="text-white font-bold uppercase tracking-tighter">{{ __('messages.write_us') }}</p>
                            <p class="text-gray-500 text-sm max-w-xs mt-2">{{ __('messages.chat_desc') }}</p>
                        </div>
                    </div>
                @else
                    @foreach($messages as $message)
                        <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }} items-end gap-3">
                            @if($message->sender_id != auth()->id())
                                <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0 border border-gray-700 shadow-sm">
                                    @if($message->sender->avatar)
                                        <img src="{{ asset('storage/' . $message->sender->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-indigo-900/50 flex items-center justify-center text-indigo-400 font-bold text-xs">
                                            ?
                                        </div>
                                    @endif
                                </div>
                            @endif
                            <div class="max-w-[75%] {{ $message->sender_id == auth()->id() ? 'bg-indigo-600 text-white rounded-l-3xl rounded-tr-3xl shadow-lg shadow-indigo-500/20' : 'bg-gray-800 text-gray-200 rounded-r-3xl rounded-tl-3xl border border-gray-700' }} p-5">
                                <p class="text-sm leading-relaxed">{{ $message->content }}</p>
                                <span class="text-[9px] font-bold opacity-50 block mt-2 uppercase tracking-widest">{{ $message->created_at->format('H:i') }}</span>
                            </div>
                            @if($message->sender_id == auth()->id())
                                <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0 border border-indigo-500/20 shadow-sm">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xs">
                                            ?
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="p-8 border-t border-gray-800 bg-gray-800/20">
                <form action="{{ route('chat.send') }}" method="POST" class="flex gap-4">
                    @csrf
                    <input type="text" name="content" required placeholder="{{ __('messages.your_message') }}" class="flex-grow bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition border">
                    <button type="submit" class="bg-indigo-600 text-white w-14 h-14 rounded-2xl flex items-center justify-center hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/20 flex-shrink-0">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-scroll to bottom
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
</script>
@endsection
