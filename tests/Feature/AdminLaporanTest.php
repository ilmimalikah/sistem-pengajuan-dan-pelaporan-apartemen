<?php

namespace Tests\Feature;

use App\Models\Fasilitas;
use App\Models\KategoriMasalah;
use App\Models\Laporan;
use App\Models\RiwayatLaporan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLaporanTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $penghuni;

    private Fasilitas $fasilitas;

    private KategoriMasalah $kategori;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->admin = User::factory()->create(['peran' => 'admin']);
        $this->penghuni = User::factory()->create([
            'nama' => 'Sari Wulandari',
            'email' => 'sari@example.test',
        ]);
        $this->fasilitas = Fasilitas::create(['nama_fasilitas' => 'Lift']);
        $this->kategori = KategoriMasalah::create(['nama_kategori' => 'Kerusakan listrik']);
    }

    public function test_admin_can_search_and_filter_all_reports(): void
    {
        $this->createReport([
            'deskripsi' => 'Kerusakan lampu lift utama.',
            'status' => 'Menunggu',
        ]);

        $penghuniLain = User::factory()->create(['nama' => 'Bayu Nugroho', 'email' => 'bayu@example.test']);
        $this->createReport([
            'id_pengguna' => $penghuniLain->id_pengguna,
            'deskripsi' => 'Kerusakan pintu lift.',
            'status' => 'Diproses',
        ]);

        $fasilitasLain = Fasilitas::create(['nama_fasilitas' => 'Parkir']);
        $penghuniParkir = User::factory()->create(['nama' => 'Rudi Santoso', 'email' => 'rudi@example.test']);
        $this->createReport([
            'id_pengguna' => $penghuniParkir->id_pengguna,
            'id_fasilitas' => $fasilitasLain->id_fasilitas,
            'deskripsi' => 'Kerusakan area parkir.',
        ]);

        $kategoriLain = KategoriMasalah::create(['nama_kategori' => 'Kebocoran air']);
        $penghuniKategori = User::factory()->create(['nama' => 'Budi Santoso', 'email' => 'budi@example.test']);
        $this->createReport([
            'id_pengguna' => $penghuniKategori->id_pengguna,
            'id_kategori' => $kategoriLain->id_kategori,
            'deskripsi' => 'Kerusakan pipa.',
        ]);

        $penghuniTanpaKataKunci = User::factory()->create(['nama' => 'Tono Santoso', 'email' => 'tono@example.test']);
        $this->createReport([
            'id_pengguna' => $penghuniTanpaKataKunci->id_pengguna,
            'deskripsi' => 'Gangguan lampu lift.',
        ]);

        $this->actingAs($this->admin)
            ->get(route('admin.laporan.index', [
                'cari' => 'Kerusakan',
                'status' => 'Menunggu',
                'fasilitas' => $this->fasilitas->id_fasilitas,
                'kategori' => $this->kategori->id_kategori,
            ]))
            ->assertOk()
            ->assertSee('Sari Wulandari')
            ->assertDontSee('Bayu Nugroho')
            ->assertDontSee('Rudi Santoso')
            ->assertDontSee('Budi Santoso')
            ->assertDontSee('Tono Santoso');
    }

    public function test_admin_can_update_status_and_view_follow_up_history(): void
    {
        $laporan = $this->createReport();

        $this->actingAs($this->admin)
            ->post(route('admin.laporan.update', $laporan->id_laporan), [
                'status' => 'Diproses',
                'catatan' => 'Teknisi dijadwalkan memeriksa lokasi.',
            ])
            ->assertRedirect(route('admin.laporan.show', $laporan->id_laporan));

        $this->assertDatabaseHas('laporan', [
            'id_laporan' => $laporan->id_laporan,
            'status' => 'Diproses',
        ]);
        $this->assertDatabaseHas('riwayat_laporan', [
            'id_laporan' => $laporan->id_laporan,
            'id_admin' => $this->admin->id_pengguna,
            'status' => 'Diproses',
            'catatan' => 'Teknisi dijadwalkan memeriksa lokasi.',
        ]);

        $this->get(route('admin.laporan.show', $laporan->id_laporan))
            ->assertOk()
            ->assertSee('Sari Wulandari')
            ->assertSee('Teknisi dijadwalkan memeriksa lokasi.')
            ->assertSee($this->admin->nama);
    }

    public function test_non_admin_cannot_manage_reports(): void
    {
        $laporan = $this->createReport();

        $this->actingAs($this->penghuni)
            ->get(route('admin.laporan.index'))
            ->assertForbidden();

        $this->actingAs($this->penghuni)
            ->post(route('admin.laporan.update', $laporan->id_laporan), [
                'status' => 'Selesai',
                'catatan' => 'Diselesaikan.',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('laporan', [
            'id_laporan' => $laporan->id_laporan,
            'status' => 'Menunggu',
        ]);
        $this->assertSame(0, RiwayatLaporan::where('id_laporan', $laporan->id_laporan)->count());
    }

    public function test_admin_must_add_a_note_when_saving_the_current_status(): void
    {
        $laporan = $this->createReport();

        $this->actingAs($this->admin)
            ->from(route('admin.laporan.show', $laporan->id_laporan))
            ->post(route('admin.laporan.update', $laporan->id_laporan), [
                'status' => 'Menunggu',
                'catatan' => '',
            ])
            ->assertSessionHasErrors('catatan');

        $this->assertSame(0, RiwayatLaporan::where('id_laporan', $laporan->id_laporan)->count());
    }

    private function createReport(array $attributes = []): Laporan
    {
        return Laporan::create(array_merge([
            'id_pengguna' => $this->penghuni->id_pengguna,
            'id_fasilitas' => $this->fasilitas->id_fasilitas,
            'id_kategori' => $this->kategori->id_kategori,
            'deskripsi' => 'Ada masalah pada fasilitas apartemen.',
            'status' => 'Menunggu',
        ], $attributes));
    }
}
