@extends('admin.dashboard')

@section('admin_content')
<div class="mb-12 flex justify-between items-center">
    <div>
        <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Повідомлення</h2>
        <p class="text-gray-500 mt-2">Керування запитами користувачів у реальному часі</p>
    </div>
</div>

<div class="bg-gray-900 rounded-[2.5rem] border border-gray-800 shadow-2xl overflow-hidden">
    @if($chats->isEmpty())
        <div class="p-20 text-center">
            <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-600 border border-gray-700">
                <i class="fas fa-inbox text-3xl"></i>
            </div>
            <p class="text-white font-bold uppercase tracking-tighter">Поки що немає повідомлень</p>
            <p class="text-gray-500 text-sm mt-2">Коли користувачі напишуть вам, чати з'являться тут.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-800/50 text-[10px] uppercase text-gray-500 font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-6">Користувач</th>
                        <th class="px-8 py-6">Останнє повідомлення</th>
                        <th class="px-8 py-6">Статус</th>
                        <th class="px-8 py-6 text-right">Дії</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50 text-sm">
                    @foreach($chats as $chat)
                        <tr class="hover:bg-gray-800/30 transition group">
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center mr-4 font-black text-white uppercase">
                                        {{ substr($chat->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-white leading-tight">{{ $chat->name }}</p>
                                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">{{ $chat->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-gray-400 truncate max-w-xs">{{ $chat->last_message?->content }}</p>
                                <span class="text-[9px] text-gray-600 uppercase font-black tracking-widest">{{ $chat->last_message?->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-8 py-6">
                                @if($chat->unread_count > 0)
                                    <span class="inline-flex items-center justify-center bg-indigo-600 text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full shadow-lg shadow-indigo-500/20 whitespace-nowrap">
                                        Не прочитано
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center text-gray-600 text-[9px] font-black uppercase tracking-widest border border-gray-800 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        Прочитано
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <a href="{{ route('admin.chat.show', $chat->id) }}" class="inline-flex items-center justify-center bg-gray-800 text-indigo-400 hover:bg-indigo-600 hover:text-white px-6 py-3 rounded-xl transition font-black text-[10px] uppercase tracking-widest">
                                    Відповісти <i class="fas fa-reply ml-2"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
