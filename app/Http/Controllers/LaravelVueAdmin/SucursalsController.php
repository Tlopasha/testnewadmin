<?php
/**
 * Controller genrated using LaravelVueAdmin
 * Help: https://github.com/razzul/laravel-vue-admin
 */

namespace App\Http\Controllers\LaravelVueAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Razzul\LaravelVueAdmin\Models\Module;
use Razzul\LaravelVueAdmin\Models\ModuleFields;

use App\Models\Sucursal;

class SucursalsController extends Controller
{
	public $show_action = true;
	public $view_col = 'nombre';
	public $listing_cols = ['id', 'nombre'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Razzul\LaravelVueAdmin\Helpers\LvHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Sucursals', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Sucursals', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Sucursals.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Sucursals');
		
		if(Module::hasAccess($module->id)) {
			return View('LaravelVueAdmin.sucursals.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('LaravelVueAdmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new sucursal.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created sucursal in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Sucursals", "create")) {
		
			$rules = Module::validateRules("Sucursals", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Sucursals", $request);
			
			return redirect()->route(config('LaravelVueAdmin.adminRoute') . '.sucursals.index');
			
		} else {
			return redirect(config('LaravelVueAdmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified sucursal.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Sucursals", "view")) {
			
			$sucursal = Sucursal::find($id);
			if(isset($sucursal->id)) {
				$module = Module::get('Sucursals');
				$module->row = $sucursal;
				
				return view('LaravelVueAdmin.sucursals.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('sucursal', $sucursal);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("sucursal"),
				]);
			}
		} else {
			return redirect(config('LaravelVueAdmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified sucursal.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Sucursals", "edit")) {			
			$sucursal = Sucursal::find($id);
			if(isset($sucursal->id)) {	
				$module = Module::get('Sucursals');
				
				$module->row = $sucursal;
				
				return view('LaravelVueAdmin.sucursals.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('sucursal', $sucursal);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("sucursal"),
				]);
			}
		} else {
			return redirect(config('LaravelVueAdmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified sucursal in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Sucursals", "edit")) {
			
			$rules = Module::validateRules("Sucursals", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Sucursals", $request, $id);
			
			return redirect()->route(config('LaravelVueAdmin.adminRoute') . '.sucursals.index');
			
		} else {
			return redirect(config('LaravelVueAdmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified sucursal from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Sucursals", "delete")) {
			Sucursal::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('LaravelVueAdmin.adminRoute') . '.sucursals.index');
		} else {
			return redirect(config('LaravelVueAdmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('sucursals')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Sucursals');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('LaravelVueAdmin.adminRoute') . '/sucursals/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Sucursals", "edit")) {
					$output .= '<a href="'.url(config('LaravelVueAdmin.adminRoute') . '/sucursals/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Sucursals", "delete")) {
					$output .= Form::open(['route' => [config('LaravelVueAdmin.adminRoute') . '.sucursals.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
