<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBenefitCompanyRequest;
use App\Http\Requests\StoreBenefitCompanyRequest;
use App\Http\Requests\UpdateBenefitCompanyRequest;
use App\Models\BenefitCompany;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BenefitCompanyController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('benefit_company_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BenefitCompany::with(['team'])->select(sprintf('%s.*', (new BenefitCompany)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'benefit_company_show';
                $editGate      = 'benefit_company_edit';
                $deleteGate    = 'benefit_company_delete';
                $crudRoutePart = 'benefit-companies';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('web_site', function ($row) {
                return $row->web_site ? $row->web_site : '';
            });
            $table->editColumn('contact', function ($row) {
                return $row->contact ? $row->contact : '';
            });
            $table->editColumn('contact_email', function ($row) {
                return $row->contact_email ? $row->contact_email : '';
            });

            $table->editColumn('country', function ($row) {
                return $row->country ? $row->country : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.benefitCompanies.index');
    }

    public function create()
    {
        abort_if(Gate::denies('benefit_company_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.benefitCompanies.create');
    }

    public function store(StoreBenefitCompanyRequest $request)
    {
        $benefitCompany = BenefitCompany::create($request->all());

        return redirect()->route('admin.benefit-companies.index');
    }

    public function edit(BenefitCompany $benefitCompany)
    {
        abort_if(Gate::denies('benefit_company_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefitCompany->load('team');

        return view('admin.benefitCompanies.edit', compact('benefitCompany'));
    }

    public function update(UpdateBenefitCompanyRequest $request, BenefitCompany $benefitCompany)
    {
        $benefitCompany->update($request->all());

        return redirect()->route('admin.benefit-companies.index');
    }

    public function show(BenefitCompany $benefitCompany)
    {
        abort_if(Gate::denies('benefit_company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefitCompany->load('team', 'benefitCompanyBenefits');

        return view('admin.benefitCompanies.show', compact('benefitCompany'));
    }

    public function destroy(BenefitCompany $benefitCompany)
    {
        abort_if(Gate::denies('benefit_company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $benefitCompany->delete();

        return back();
    }

    public function massDestroy(MassDestroyBenefitCompanyRequest $request)
    {
        $benefitCompanies = BenefitCompany::find(request('ids'));

        foreach ($benefitCompanies as $benefitCompany) {
            $benefitCompany->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
