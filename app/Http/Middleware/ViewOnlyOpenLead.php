<?php

namespace App\Http\Middleware;

use App\Models\Lead;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class ViewOnlyOpenLead
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isTeleCaller = auth()->user()->hasRole('Tele Caller');

        $isUpdateRoute = in_array(Route::getCurrentRoute()->getName(), ["leads.update", "leads.edit", 'book-appointment']);

      
        if ($isTeleCaller && !$isUpdateRoute) {
            $lead = Lead::where('opened_by', auth()->user()->id)->first();

            if ($lead != null) {
               
                return redirect()->route('leads.edit', ['lead' => $lead->id]);
            }
        }

        return $next($request);
    }
}
