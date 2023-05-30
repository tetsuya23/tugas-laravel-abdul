<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use App\Models\Transactions;
use App\Models\Catalog;
use App\Models\Author;
use App\Models\Book;
use App\Models\Member;
use App\Models\Publisher;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $members = Member::with('user')->get();
        //$books = Book::with('publisher')->get();
        //$publishers = Publisher::with('books')->get();
        //$authors = Author::with('books')->get();
        //$catalogs = Catalog::with('books')->get();

        //no 1
        $data = Member::select('*')
                    ->join('users','users.member_id','=','members.id')
                    ->get();


        //no 2
        $data2 = Member::select('*')
                    ->leftJoin('users','users.member_id','=','members.id')
                    ->where('users.id', NULL)
                    ->get();
                    

        //no 3 	Tampilkan id dan nama anggota yg belum pernah melakukan peminjaman
        $data3 = Transactions::select('members.id', 'members.name')
                    ->rightJoin('members', 'members.id', '=', 'transactions.member_id')
                    ->where('transactions.member_id', NULL)
                    ->get();


        //no 4	Tampilan id, nama, telp anggota yg pernah melakukan peminjaman
        $data4 = Member::select('members.id', 'members.name', 'members.phone_number')
                    ->join('transactions', 'transactions.member_id', '=', 'members.id')
                    ->orderBy('members.id', 'asc')
                    ->get();


        //no 5.	Tampilkan id, nama, telp anggota yg pernah melakukan peminjaman lebih dari 1x
        $data5 = Member::selectRaw('COUNT(transactions.member_id) as total_transactions, members.id, members.name, members.phone_number')
                    ->join('transactions', 'transactions.member_id', '=', 'members.id')
                    ->groupBy('transactions.member_id', 'members.id', 'members.name', 'members.phone_number')
                    ->having('total_transactions', '>', 1)
                    ->get();

        //no 6.	Tampilkan nama, telp, alamat, tanggal pinjam dan tanggal kembali
        $data6 = Member::select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
                    ->join('transactions', 'members.id', '=', 'transactions.member_id')
                    ->get();

        //no 7.	Tampilkan nama, telp, alamat, tanggal pinjam dan tanggal kembali yang tanggal kembalinya ada di bulan juni
        $data7 = Member::select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
                    ->join('transactions', 'members.id', '=', 'transactions.member_id')
                    ->whereMonth('transactions.date_end', 6)
                    ->get();
    

        //n0 8.	Tampilkan nama, telp, alamat, tanggal pinjam dan tanggal kembali yang tanggal pinjamnya ada di bulan mei
        $data8 = Member::select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
                    ->join('transactions', 'members.id', '=', 'transactions.member_id')
                    ->whereMonth('transactions.date_start', 5)
                    ->get();

        //no 9.	Tampilkan nama, telp, alamat, tanggal pinjam dan tanggal kembali yang tanggal pinjam dan tanggal kembalinya ada di bulan juni
        $data9 = Member::select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
                    ->join('transactions', 'members.id', '=', 'transactions.member_id')
                    ->whereMonth('transactions.date_start', 6)
                    ->whereMonth('transactions.date_end', 6)
                    ->get();

        //no10.	Tampilkan nama, telp, alamat, tanggal pinjam dan tanggal kembali yang tanggal pinjam dan tanggal kembalinya ada di bulan juni

        $data10 = Member::select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
                    ->join('transactions', 'members.id', '=', 'transactions.member_id')
                    ->where('members.address', '=', 'Bandung')
                    ->get();

        // no 11.	Tampilkan nama, telp, alamat, tanggal pinjam dan tanggal kembali yang anggotanya beralamat di Bandung dan berjenis kelamin perempuan
        $data11 = Member::select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
                    ->join('transactions', 'members.id', '=', 'transactions.member_id')
                    ->where('members.gender', '=', 'P')
                    ->get();

        //no 12.	Tampilkan nama, telp, alamat, tanggal pinjam, tanggal kembali, isbn dan qty, dimana jumlah qty lebih dari 1
        $data12 = Member::select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end', 'books.isbn', 'transaction_details.qty')
            	    ->join('transactions', 'members.id', '=', 'transactions.member_id')
            	    ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
            	    ->join('books', 'transaction_details.book_id', '=', 'books.id')
            	    ->where('transaction_details.qty', '>', 1)
            	    ->get();
        //no 13.	Tampilkan nama, telp, alamat, tanggal pinjam, tanggal kembali, isbn, qty, judul buku, harga pinjam dan total harga (qty di kali harga pinjam)
        $data13 = Member::selectRaw('SUM(transaction_details.qty * books.price) as total_price, members.name, members.phone_number, members.address, transactions.date_start, transactions.date_end, books.isbn, transaction_details.qty, books.title, books.price')
                    ->join('transactions', 'members.id', '=', 'transactions.member_id')
                    ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
                    ->join('books', 'transaction_details.book_id', '=', 'books.id')
                    ->groupBy('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end', 'books.isbn', 'transaction_details.qty', 'books.title', 'books.price')
                    ->get();
    
        //NO 14.	Tampilkan nama anggota, telp anggota, alamat anggota, tanggal pinjam, tanggal kembali, isbn, qty, judul buku, nama penerbit, nama pengarang dan nama katalog
        $data14 = Member::select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end', 'books.isbn', 'transaction_details.qty', 'books.title', 'books.price', 'publishers.name as publisher', 'authors.name as author', 'catalogs.name as catalog')
                    ->join('transactions', 'members.id', '=', 'transactions.member_id')
                    ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
                    ->join('books', 'transaction_details.book_id', '=', 'books.id')
                    ->join('authors', 'books.author_id', '=', 'authors.id')
                    ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
                    ->join('catalogs', 'books.catalog_id', '=', 'catalogs.id')
                    ->orderBy( 'members.name', 'asc')
                    ->get();

        //no15.	Tampilkan semua data katalog, judul buku, dimana semua data katalog mempunyai relasi ke data buku
        $data15 = Catalog::select('catalogs.id as catalog_id', 'catalogs.name', 'catalogs.created_at', 'catalogs.updated_at', 'books.title')
                    ->join('books', 'catalogs.id', '=', 'books.catalog_id')
                    ->orderBy('catalogs.name', 'asc')
                    ->get();
    
        //no 16.	Tampilkan semua data buku dan nama penerbit. Beserta data buku yang tidak mempunyai relasi ke data penerbit
        $data16 = Book::leftJoin('publishers', 'books.publisher_id', '=', 'publishers.id')
                    ->select('books.*', 'publishers.name')
                    ->get();

        //no17.	Tampilkan ada berapa jumlah pengarang PG05 pada table buku (contoh dengan id publisher -> 11)
        $data17 = Book::where('publisher_id', 11)->get();

        
        //18.	Tampilkan data buku yang harganya lebih dari 10000
        $data18 = Book::where('price', '>', '15000')
                    ->get();

        // no 19 Tampilkan seluruh data buku yang diterbitkan oleh Penerbit 01, dimana buku tersebut harus mempunyai qty lebih dari 10
        $data19 = Book::where('publisher_id', '=', 'publisher_01')
                    ->where('qty', '>', 10)
                    ->get();

        //no 20	Tampilkan seluruh data anggota yang baru ditambahkan pada bulan juni
        $data20 = Member::WhereMonth('created_at', '=', 6)
                    ->get();



        //return $books;
        return view('home');  
    }
}
