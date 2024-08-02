<?php

namespace App\Livewire;

use App\Models\HelpDesks;
use Livewire\Component;
use Carbon\Carbon;
class AuthChecking extends Component
{
    public $activeTab = 'active';
    public $records;

    public $selectedCatalog = 'active';
    public $selectedNew = 'active';
    public function confirmByAdmin($taskId)
    {
        $task = HelpDesks::find($taskId);
        if ($task) {
            $task->update([
                'status' => 'Open',
                'category' => $task->category ?? 'N/A',
                'mail'   => $task->mail ?? 'N/A',
            ]);
        }
        return redirect()->to('/HelpDesk');
    }

    public function openForDesks($taskId)
    {
        $task = HelpDesks::find($taskId);

        if ($task) {
            $task->update(['status' => 'Completed']);
        }
        return redirect()->to('/HelpDesk');
    }

    public function closeForDesks($taskId)
    {
        $task = HelpDesks::find($taskId);

        if ($task) {
            $task->update(['status' => 'Open']);
        }
        return redirect()->to('/HelpDesk');
    }
    public function pendingForDesks($taskId)
    {
        $task = HelpDesks::find($taskId);

        if ($task) {
            $task->update(['status' => 'Pending']);
        }
        return redirect()->to('/HelpDesk');
    }
    public $forIT, $forHR, $forFinance, $forAdmin;

    public function render()
    {
        if (auth()->guard('it')->check()) {
            $companyId = auth()->guard('it')->user()->company_id;
        
            $this->forIT = HelpDesks::with('emp')
                ->whereHas('emp', function ($query) use ($companyId) {
                    $query->where('company_id', $companyId);
                })
                ->orderBy('created_at', 'desc')
                ->whereIn('category', ['Request For IT', 'Distribution List Request', 'New Laptop', 'New Distribution Request', 'New Mailbox Request', 'Devops Access Request', 'New ID Card', 'MMS Request', 'Desktop Request', 'N/A'])
                ->get();
        } elseif (auth()->guard('hr')->check()) {
            $companyId = auth()->guard('hr')->user()->company_id;

            $this->forHR = HelpDesks::with('emp')
                ->whereHas('emp', function ($query) use ($companyId) {
                    $query->where('company_id', $companyId);
                })
                ->orderBy('created_at', 'desc')
                ->whereIn('category', ['Employee Information', 'Hardware Maintenance', 'Incident Report', 'Privilege Access Request', 'Security Access Request', 'Technical Support'])
                ->get();
        } elseif (auth()->guard('finance')->check()) {
            $companyId = auth()->guard('finance')->user()->company_id;

            $this->forFinance = HelpDesks::with('emp')
                ->whereHas('emp', function ($query) use ($companyId) {
                    $query->where('company_id', $companyId);
                })
                ->orderBy('created_at', 'desc')
                ->whereIn('category', ['Income Tax', 'Loans', 'Payslip'])
                ->get();
        } elseif (auth()->guard('admins')->check()) {
            $companyId = auth()->guard('admins')->user()->company_id;
            $thresholdDate = Carbon::now()->subDays(7);
            HelpDesks::where('status', 'Recent')
                ->where('created_at', '<=', $thresholdDate)
                ->update(['status' => 'Open']);
            $this->forAdmin = HelpDesks::with('emp')
                ->whereHas('emp', function ($query) use ($companyId) {
                    $query->where('company_id', $companyId);
                })
                ->orderBy('created_at', 'desc') // Order by created_at in descending order to get the most recent records first
                ->get();
            
        }
        if ($this->selectedNew == 'active') {
            $this->forAdmin = HelpDesks::with('emp')
                ->where('status', 'Recent')
                ->orderBy('created_at', 'desc')

                ->get();
         
        }
        if ($this->activeTab == 'active') {
            $this->forIT = HelpDesks::with('emp')
                ->where('status', 'Open')
                ->orderBy('created_at', 'desc')
                ->whereIn('category', ['Request For IT', 'Distribution List Request', 'New Laptop', 'New Distribution Request', 'New Mailbox Request', 'Devops Access Request', 'New ID Card', 'MMS Request', 'Desktop Request', 'N/A'])
                ->get();
        } elseif ($this->activeTab == 'pending') {
            $this->forIT = HelpDesks::with('emp')
                ->where('status', 'Pending')
                ->orderBy('created_at', 'desc')

                ->get();
        } elseif ($this->activeTab == 'closed') {
            $this->forIT = HelpDesks::with('emp')
                ->where('status', 'Completed')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        if ($this->activeTab == 'active') {
            $this->forHR = HelpDesks::with('emp')
                ->where('status', 'Open')
                ->orderBy('created_at', 'desc')
                ->whereIn('category', ['Employee Information', 'Hardware Maintenance', 'Incident Report', 'Privilege Access Request', 'Security Access Request', 'Technical Support'])
                ->get();
        } elseif ($this->activeTab == 'pending') {
            $this->forHR = HelpDesks::with('emp')
                ->where('status', 'Pending')
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($this->activeTab == 'closed') {
            $this->forHR = HelpDesks::with('emp')
                ->where('status', 'Completed')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        if ($this->activeTab == 'active') {
            $this->forFinance = HelpDesks::with('emp')
                ->where('status', 'Open')
                ->orderBy('created_at', 'desc')
                ->whereIn('category', ['Income Tax', 'Loans', 'Payslip'])
                ->get();
        } elseif ($this->activeTab == 'pending') {
            $this->forFinance = HelpDesks::with('emp')
                ->where('status', 'Pending')
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($this->activeTab == 'closed') {
            $this->forFinance = HelpDesks::with('emp')
                ->where('status', 'Completed')
                ->orderBy('created_at', 'desc')
                ->get();
        }


        return view('livewire.auth-checking');
    }
}
