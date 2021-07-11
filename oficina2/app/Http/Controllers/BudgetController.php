<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

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
        $budgets = $this->budgets->all();
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
    public function store(Request $request)
    {
        $request->validate([

                'client' => ['required', 'string'],
                'salesman' => ['required', 'string'],
                'description' => ['required', 'string'],
                'value' => ['required', 'string'],
        ]);

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
        $budget = $this->budgets->find($id);

        return json_encode($budget);
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
    public function update(Request $request, $id)
    {
        //Não use validações em controllers e sim em classes de Requisição.
        $request->validate([
            
                'client' => ['required', 'string'],
                'salesman' => ['required', 'string'],
                'description' => ['required', 'string'],
                'value' => ['required', 'string'],
        ]);

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
        $budgets = Budget::where('client', 'LIKE', '%' . $str . '%')->orderBy('created_at', 'DESC')->get();

        return view('admin.budget.index', compact('budgets'));
    }
}
