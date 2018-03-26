<?php

namespace App\Http\Controllers;

// Facades
use Illuminate\Http\Request;
use Carbon\Carbon;

// Models
use App\Adjustment;
use App\AdjustmentOrder;
use App\Client;

// Notifications


class AdjustmentController extends Controller
{
	public function indexForValidador()
	{
		$ordenes = AdjustmentOrder::paginate(15,['*'],'general');

		$aprobadas = AdjustmentOrder::where('status',1)->paginate(5,['*'],'aprobadas');
		$sinAprobar = AdjustmentOrder::where('status',0)->paginate(5,['*'],'sinAprobar');
		$finalizadas = AdjustmentOrder::where('status',2)->paginate(5,['*'],'finalizadas');

		return view('validador.adjustment.home',compact('ordenes','aprobadas','sinAprobar','finalizadas'));
	}
}
