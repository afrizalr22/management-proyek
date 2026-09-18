<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menyelaraskan schema Quotation dengan workflow aplikasi.
     */
    public function up(): void
    {
        $clientIdWasMissing =
            ! Schema::hasColumn(
                'quotations',
                'client_id'
            );

        $createdByWasMissing =
            ! Schema::hasColumn(
                'quotations',
                'created_by'
            );

        Schema::table(
            'quotations',
            function (Blueprint $table) use (
                $clientIdWasMissing,
                $createdByWasMissing
            ): void {
                if ($clientIdWasMissing) {
                    $table
                        ->unsignedBigInteger('client_id')
                        ->nullable()
                        ->after('id');
                }

                if ($createdByWasMissing) {
                    $table
                        ->unsignedBigInteger('created_by')
                        ->nullable()
                        ->after('project_id');
                }

                if (
                    ! Schema::hasColumn(
                        'quotations',
                        'sent_at'
                    )
                ) {
                    $table
                        ->dateTime('sent_at')
                        ->nullable()
                        ->after('status');
                }

                if (
                    ! Schema::hasColumn(
                        'quotations',
                        'approved_at'
                    )
                ) {
                    $table
                        ->dateTime('approved_at')
                        ->nullable()
                        ->after('sent_at');
                }

                if (
                    ! Schema::hasColumn(
                        'quotations',
                        'rejected_at'
                    )
                ) {
                    $table
                        ->dateTime('rejected_at')
                        ->nullable()
                        ->after('approved_at');
                }
            }
        );

        /*
         * Hubungkan data Quotation lama dengan Client
         * berdasarkan email atau nama perusahaan.
         */
        if ($clientIdWasMissing) {
            DB::table('quotations')
                ->whereNull('client_id')
                ->orderBy('id')
                ->chunkById(
                    100,
                    function ($quotations): void {
                        foreach ($quotations as $quotation) {
                            $clientId = null;

                            if (
                                filled(
                                    $quotation->client_email
                                        ?? null
                                )
                            ) {
                                $clientId = DB::table('clients')
                                    ->where(
                                        'email',
                                        $quotation->client_email
                                    )
                                    ->value('id');
                            }

                            if (! $clientId) {
                                $clientId = DB::table('clients')
                                    ->where(
                                        'company_name',
                                        $quotation->client_name
                                    )
                                    ->value('id');
                            }

                            if ($clientId) {
                                DB::table('quotations')
                                    ->where(
                                        'id',
                                        $quotation->id
                                    )
                                    ->update([
                                        'client_id' =>
                                            $clientId,
                                    ]);
                            }
                        }
                    }
                );
        }

        /*
         * Seluruh Quotation baru wajib memiliki Client.
         * Data lama harus berhasil dipetakan terlebih dahulu.
         */
        if (
            DB::table('quotations')
                ->whereNull('client_id')
                ->exists()
        ) {
            throw new \RuntimeException(
                'Migration Quotation dihentikan karena terdapat data lama yang belum terhubung dengan Client.'
            );
        }

        /*
         * Lepaskan foreign key Project lama sebelum
         * mengubahnya menjadi nullable.
         */
        Schema::table(
            'quotations',
            function (Blueprint $table): void {
                $table->dropForeign([
                    'project_id',
                ]);
            }
        );

        Schema::table(
            'quotations',
            function (Blueprint $table): void {
                $table
                    ->unsignedBigInteger('client_id')
                    ->nullable(false)
                    ->change();

                $table
                    ->unsignedBigInteger('project_id')
                    ->nullable()
                    ->change();

                $table
                    ->string(
                        'client_contact_person'
                    )
                    ->nullable()
                    ->change();

                $table
                    ->text('project_location')
                    ->nullable()
                    ->change();
            }
        );

        Schema::table(
            'quotations',
            function (Blueprint $table) use (
                $clientIdWasMissing,
                $createdByWasMissing
            ): void {
                if ($clientIdWasMissing) {
                    $table
                        ->foreign('client_id')
                        ->references('id')
                        ->on('clients')
                        ->restrictOnDelete();
                }

                if ($createdByWasMissing) {
                    $table
                        ->foreign('created_by')
                        ->references('id')
                        ->on('users')
                        ->nullOnDelete();
                }

                $table
                    ->foreign('project_id')
                    ->references('id')
                    ->on('projects')
                    ->nullOnDelete();
            }
        );

        if (
            ! Schema::hasIndex(
                'quotations',
                'quotations_project_id_unique'
            )
        ) {
            Schema::table(
                'quotations',
                function (Blueprint $table): void {
                    $table->unique(
                        'project_id',
                        'quotations_project_id_unique'
                    );
                }
            );
        }

        if (
            ! Schema::hasIndex(
                'quotations',
                'quotations_client_id_status_index'
            )
        ) {
            Schema::table(
                'quotations',
                function (Blueprint $table): void {
                    $table->index(
                        [
                            'client_id',
                            'status',
                        ],
                        'quotations_client_id_status_index'
                    );
                }
            );
        }

        if (
            ! Schema::hasIndex(
                'quotations',
                'quotations_quotation_date_status_index'
            )
        ) {
            Schema::table(
                'quotations',
                function (Blueprint $table): void {
                    $table->index(
                        [
                            'quotation_date',
                            'status',
                        ],
                        'quotations_quotation_date_status_index'
                    );
                }
            );
        }
    }

    /**
     * Mengembalikan schema Quotation ke bentuk awal.
     */
    public function down(): void
    {
        if (
            Schema::hasIndex(
                'quotations',
                'quotations_quotation_date_status_index'
            )
        ) {
            Schema::table(
                'quotations',
                function (Blueprint $table): void {
                    $table->dropIndex(
                        'quotations_quotation_date_status_index'
                    );
                }
            );
        }

        if (
            Schema::hasIndex(
                'quotations',
                'quotations_client_id_status_index'
            )
        ) {
            Schema::table(
                'quotations',
                function (Blueprint $table): void {
                    $table->dropIndex(
                        'quotations_client_id_status_index'
                    );
                }
            );
        }

        if (
            Schema::hasIndex(
                'quotations',
                'quotations_project_id_unique'
            )
        ) {
            Schema::table(
                'quotations',
                function (Blueprint $table): void {
                    $table->dropUnique(
                        'quotations_project_id_unique'
                    );
                }
            );
        }

        Schema::table(
            'quotations',
            function (Blueprint $table): void {
                $table->dropForeign([
                    'project_id',
                ]);

                if (
                    Schema::hasColumn(
                        'quotations',
                        'client_id'
                    )
                ) {
                    $table->dropForeign([
                        'client_id',
                    ]);
                }

                if (
                    Schema::hasColumn(
                        'quotations',
                        'created_by'
                    )
                ) {
                    $table->dropForeign([
                        'created_by',
                    ]);
                }
            }
        );

        Schema::table(
            'quotations',
            function (Blueprint $table): void {
                $table->dropColumn([
                    'client_id',
                    'created_by',
                    'sent_at',
                    'approved_at',
                    'rejected_at',
                ]);
            }
        );

        /*
         * Project hanya dapat dikembalikan menjadi wajib
         * apabila tidak terdapat Quotation tanpa Project.
         */
        if (
            DB::table('quotations')
                ->whereNull('project_id')
                ->doesntExist()
        ) {
            Schema::table(
                'quotations',
                function (Blueprint $table): void {
                    $table
                        ->unsignedBigInteger('project_id')
                        ->nullable(false)
                        ->change();
                }
            );
        }

        Schema::table(
            'quotations',
            function (Blueprint $table): void {
                $table
                    ->foreign('project_id')
                    ->references('id')
                    ->on('projects')
                    ->cascadeOnDelete();
            }
        );
    }
};