<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Catalog;
use App\Models\Member;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Transactions;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $total_anggota = Member::count();
        $total_buku = Book::count();
        $total_peminjaman = Transaction::whereMonth('tgl_pinjam', date('m'))->count();
        $total_penerbit = Publisher::count();

        $data_donut = Book::select(DB::raw("COUNT(id_penerbit) as total"))->groupBy('publisher_id')->orderBy('publisher_id', 'asc')->pluck('total');
        $label_donut = Publisher::orderBy('publishers.id', 'asc')->join('books', 'books.publisher_id', '=', 'publishers.id')->groupBy('name')->pluck('name');

        $label_bar = ['Peminjman'];
        $data_bar = [];

        foreach ($label_bar as $key => $value) {
            $data_bar[$key]['label'] = $label_bar[$key];
            $data_bar[$key]['backgroundColor'] = '60,141,188,0.9';
            $data_month = [];

            foreach (range(1, 12) as $month) {
                $data_month[] = Peminjaman::select(DB::raw("COUNT(*) as total"))->whereMonth('tgl_pinjam', $month)->first()->total;
            }

            $data_bar[$key]['data'] = $data_month;
        }

        return view('admin.dashboard', compact('total_anggota', 'total_buku', 'total_peminjaman', 'total_penerbit'));
    }


    public function katalog()
    {
        $data_katalog = Katalog::all();
        return view('admin.katalog.katalog', compact('data_katalog'));
    }

    public function penerbit()
    {
        $data_penerbit = Penerbit::all();
        return view('admin.penerbit', compact('data_penerbit'));
    }

    public function pengarang()
    {
        $data_pengarang = Pengarang::all();
        return view('admin.pengarang', compact('data_pengarang'));
    }
}
