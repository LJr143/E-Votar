<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class SystemUserAdminExport implements FromView, ShouldAutoSize, WithDrawings
{
    public $admins;
    public $search;
    public $filter;

    public function __construct($search, $filter){
        $this->search = $search;
        $this->filter = $filter;
    }

    public function view(): View
    {
        $query = User::query();

        $query->whereHas('roles', function ($q) {
            $q->whereIn('name', ['superadmin', 'admin', 'technical_officer', 'student-council-watcher', 'local-council-watcher']);
        });

        if ($this->search) {
            $query->where('first_name', 'like', '%' . $this->search . '%');
        }

        if ($this->filter === 'all_users') {
            $query->whereHas('roles', function ($q) {
                $q->whereIn('name', ['superadmin', 'admin', 'technical_officer', 'student-council-watcher', 'local-council-watcher']);
            });
        } elseif ($this->filter === 'admin') {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'admin');
            });
        } elseif ($this->filter === 'student-council-watcher') {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'student-council-watcher');
            });
        } elseif ($this->filter === 'technical_officer') {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'technical_officer');
            });
        }

        $this->admins = $query->get();

        return view('evotar.reports.exports.systemUserAdmin', [
            'admins' => $this->admins
        ]);
    }


    /**
     * @throws Exception
     */
    // Alternative drawing approach
    public function drawings(): Drawing
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('University Logo');
        $drawing->setPath(public_path('storage/assets/image/University of Southeastern Philippines Tagum Unit.png'));
        $drawing->setHeight(50);
        $drawing->setWidth(300);
        $drawing->setOffsetX(250);

        $drawing->setCoordinates('I1');


        return $drawing;
    }
}
