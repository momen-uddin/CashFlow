<!-- telecom-packs.blade.php -->
@props(['provider', 'packs'])

<div
    class="p-4 bg-white rounded-lg shadow-[0px 14px 34px 0px rgba(0,0,0,0.08)] dark:bg-zinc-900 dark:shadow-[0px 4px 34px rgba(0,0,0,0.06)]">
    <div class="row col-12 col-md-12 col-sm-12">
        @foreach ($packs as $pack)
            <div class="col-md-3 col-sm-12 mb-1">
                <h4 class="fw-bold text-[#f84e4e]">{{ $provider }} {{ $pack['type'] }}</h4>
                <hr>
                <table class="mt-2 col-md-12 col-sm-12 col-12" style="font-size: 0.9em;">
                    @foreach ($pack['data'] as $item)
                        <tr class="mt-1 mb-1 border-bottom">
                            {{-- <div class="d-flex justify-content-between"> --}}
                            <td class="font-semibold">{{ $item['title'] }}</td>
                            <td class="font-semibold">{{ $item['validity'] == 0 ? 'Unlimited' : $item['validity'] }}
                                Days</td>
                            <td class="font-semibold">{{ $item['price'] }} ৳</td>
                            {{-- </div> --}}
                        </tr>

                    @endforeach
                </table>
            </div>
        @endforeach
    </div>
</div>
