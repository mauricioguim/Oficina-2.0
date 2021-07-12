<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

use App\Http\Requests\BudgetRequest;
use Illuminate\Http\Request;
use App\Models\Budget;

class BudgetController extends Controller
{
    private $budgets;

    public function __construct(Budget $budgets)
    {
        $this->budgets = $budgets;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $budgets = $this->budgets->paginate(10);
        return view('admin.budget.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.budget.crud');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BudgetRequest $request)
    {
        $datas = $request->all();
        
        $this->budgets->create($datas);

        // retorna para a página index do CRUD de Orçamentos com mensagem de aviso
        return redirect(route('orcamento.index'))->with('success', 'Orçamento cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $budgets = $this->budgets->find($id);

        return json_encode($budgets);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $budget = $this->budgets->find($id);

        return view('admin.budget.crud', compact('budget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BudgetRequest $request, $id)
    {
        $datas = $request->all();
        $budget = $this->budgets->find($id);
        
        $budget->update($datas);

        // retorna para a página index do CRUD de Orçamentos com mensagem de aviso
        return redirect(route('orcamento.index'))->with('success', 'Orçamento atualizado com sucesso!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $budget = $this->budgets->find($id);
        $budget->delete();

        return redirect(route('orcamento.index'))->with('success', 'Orçamento deletado com sucesso!');
    
    }

    public function search(Request $request)
    {
        $str = $request->input('search');
        $budgets = Budget::where('client', 'LIKE', '%' . $str . '%')
        ->orWhere('salesman', 'LIKE', '%' . $str . '%')
        ->orWhere('created_at', 'LIKE', '%' . $str . '%')->orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.budget.index', compact('budgets', 'str'));
    }
}
