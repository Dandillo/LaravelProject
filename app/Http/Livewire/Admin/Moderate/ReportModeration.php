<?php

namespace App\Http\Livewire\Admin\Moderate;

use App\Models\Report;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class ReportModeration extends Component
{
    public $is_checked = 0;


    //  Жалоба обработана
    public function report_checked($report_id)
    {
        $report = Report::find($report_id);
        $report->update([
            'is_checked' => true,
        ]);

        session()->flash('scs_msg', 'Жалоба проверена');
    }


    public function render()
    {
        $reports = Report::where('is_checked', $this->is_checked)->paginate(Config::get('paginate_count', 20));
        return view('livewire.admin.moderate.report-moderation', compact('reports'));
    }
}
