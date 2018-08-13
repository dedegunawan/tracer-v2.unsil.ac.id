<?php
/**
 * ButirPertanyaan, list all pertanyaan with the optionType
 */
class ButirPertanyaan
{
    function alumni() {
        return array(
            '1' => array(
                'pertanyaan' => 'Apakah saat Saudara mendapatkan pekerjaan pertama kali sudah sesuai dengan pendidikan dan spesifikasi keilmuan?',
                'pilihan' => array(
                    1 => 'Ya',
                    2 => 'Tidak',
                ),
                'required' => true,
            ),
            '2' => array(
                'pertanyaan' => 'Apakah Saudara mengalami lebih dari tiga kali berganti pekerjaan sebelum mendapatkan pekerjaan yang sesuai dengan pendidikan dan spesifikasi keilmuan?',
                'pilihan' => array(
                    1 => 'Ya',
                    2 => 'Tidak',
                ),
                'required' => true,
            ),
            '3' => array(
                'pertanyaan' => 'Apakah saat ini pekerjaan Saudara sesuai dengan pendidikan dan spesifikasi?',
                'pilihan' => array(
                    1 => 'Ya',
                    2 => 'Tidak',
                ),
                'required' => true,
            ),
            '4' => array(
                'pertanyaan' => 'Apabila pekerjaan Saudara tidak sesuai dengan pendidikan dan spesifikasi, apakah saudara bisa mengatasi kesulitan pekerjaan?',
                'pilihan' => array(
                    1 => 'Ya',
                    2 => 'Tidak',
                ),
                'required' => true,
            ),
            '5' => array(
                'pertanyaan' => 'Apakah pekerjaan Saudara saat ini berhubungan dengan keahlian yang didapat dari kurikulum lokal saat kuliah?',
                'pilihan' => array(
                    1 => 'Ya',
                    2 => 'Tidak',
                ),
                'required' => true,
            ),
            '6' => array(
                'pertanyaan' => 'Sebelum mendapat pekerjaan, apakah Saudara ingin berprofesi sebagai Ahli di bidang pendidikan yang Anda tempuh?',
                'pilihan' => array(
                    1 => 'Ya',
                    2 => 'Tidak',
                ),
                'required' => true,
            ),
            '7' => array(
                'pertanyaan' => 'Setelah lulus dari Universitas Siliwangi, berapa lama Anda mendapat pekerjaan?',
                'pilihan' => array(
                    1 => '0 - 12 bulan',
                    2 => '1 - 2 tahun',
                    3 => '2 - 3 tahun',
                    4 => 'lebih dari 3 tahun',
                ),
                'required' => true,
            ),
            '8' => array(
                'pertanyaan' => 'Mata Kuliah yang ada dalam kurikulum saat Saudara Kuliah sesuai dengan lapangan kerja',
                'pilihan' => array(
                    1 => 'Sangat Sesuai',
                    2 => 'Sesuai',
                    3 => 'Cukup Sesuai',
                    4 => 'Kurang Sesuai',
                    5 => 'Tidak Sesuai',
                ),
                'required' => true,
            ),
            '9' => array(
                'pertanyaan' => 'Model pembelajaran yang diterapkan saat Saudara Kuliah menunjang profesionalisme Anda saat bekerja',
                'pilihan' => array(
                    1 => 'Sangat Sesuai',
                    2 => 'Sesuai',
                    3 => 'Cukup Sesuai',
                    4 => 'Kurang Sesuai',
                    5 => 'Tidak Sesuai',
                ),
                'required' => true,
            ),
            '10' => array(
                'pertanyaan' => 'Kompetensi yang Saudara peroleh saat kuliah dibutuhkan dunia kerja',
                'pilihan' => array(
                    1 => 'Sangat Sesuai',
                    2 => 'Sesuai',
                    3 => 'Cukup Sesuai',
                    4 => 'Kurang Sesuai',
                    5 => 'Tidak Sesuai',
                ),
                'required' => true,
            ),
            '11' => array(
                'pertanyaan' => 'Tulis saran dan masukan Anda untuk peningkatan lulusan Universitas Siliwangi Tasikmalaya',
                'pilihan' => 'textarea',
                'required' => true,
            ),
        );
    }
    function pengguna() {
        return array(
            '1' => array(
                'pertanyaan' => 'Bagaimana Integritas (etika & moral) Lulusan kami dalam lingkungan kerja di Perusahaan/ Lembaga/ Dinas/ Instansi Bapak?',
                'pilihan' => array(
                    1 => 'Sangat Baik',
                    2 => 'Baik',
                    3 => 'Cukup',
                    4 => 'Kurang',
                ),
                'required' => true,
            ),

            '2' => array(
                'pertanyaan' => 'Bagaimana keahlian Bidang Ilmu (profesionalisme) lulusan kami saat bekerja di Perusahaan/ Lembaga/ Dinas/ Instansi Saudara?',
                'pilihan' => array(
                    1 => 'Sangat Baik',
                    2 => 'Baik',
                    3 => 'Cukup',
                    4 => 'Kurang',
                ),
                'required' => true,
            ),

            '3' => array(
                'pertanyaan' => 'Bagaimana kemampuan bahasa asing (bahasa Inggris atau bahasa lainnya ) lulusan kami?',
                'pilihan' => array(
                    1 => 'Sangat Baik',
                    2 => 'Baik',
                    3 => 'Cukup',
                    4 => 'Kurang',
                ),
                'required' => true,
            ),

            '4' => array(
                'pertanyaan' => 'Bagaimana kemampuan lulusan kami dalam hal penguasaan dan penggunaan teknologi informasi dalam memperlancar pekerjaan?',
                'pilihan' => array(
                    1 => 'Sangat Baik',
                    2 => 'Baik',
                    3 => 'Cukup',
                    4 => 'Kurang',
                ),
                'required' => true,
            ),

            '5' => array(
                'pertanyaan' => 'Bagaimana kemampuan lulusan kami dalam aspek komunikasi dan sosialisasi dalam lingkungan kerja di Perusahaan/ Lembaga/ Dinas/ Instansi Saudara?',
                'pilihan' => array(
                    1 => 'Sangat Baik',
                    2 => 'Baik',
                    3 => 'Cukup',
                    4 => 'Kurang',
                ),
                'required' => true,
            ),

            '6' => array(
                'pertanyaan' => 'Bagaimana kemampuan kerjasama tim dan keorganisasian lulusan kami dalam lingkungan kerja di Perusahaan/ Lembaga/ Dinas/ Instansi Saudara?',
                'pilihan' => array(
                    1 => 'Sangat Baik',
                    2 => 'Baik',
                    3 => 'Cukup',
                    4 => 'Kurang',
                ),
                'required' => true,
            ),

            '7' => array(
                'pertanyaan' => 'Bagaimana proses pengembangan diri (Kemampuan profesionalisme dan kompetensi) lulusan kami saat bekerja di Perusahaan/ Lembaga/ Dinas/ Instansi Saudara?',
                'pilihan' => array(
                    1 => 'Sangat Baik',
                    2 => 'Baik',
                    3 => 'Cukup',
                    4 => 'Kurang',
                ),
                'required' => true,
            ),

            '8' => array(
                'pertanyaan' => 'Tulis saran dan masukan Anda untuk peningkatan lulusan Universitas Siliwangi Tasikmalaya',
                'pilihan' => 'textarea',
                'required' => true,
            ),

        );
    }
    function optionAnalisaAlumni() {
        return array(
            /*
            '1' => 'Database Alumni',
            */
            '2' => 'Hasil Kuisioner',
            '6' => 'Kesesuaian kurikulum dengan kondisi lapangan kerja',
            '7' => 'Distribusi Frekuensi tentang kurikulum dengan lapangan kerja',
            '8' => 'Tingkat penyerapan alumni',
        );
    }
    function optionAnalisaPengguna() {
        return array(
            '8' => 'Daya Serap',
            '2' => 'Tanggapan (Hasil)',
            '7' => 'Distribusi Frekuensi Jawaban Pengguna',
        );
    }
}
