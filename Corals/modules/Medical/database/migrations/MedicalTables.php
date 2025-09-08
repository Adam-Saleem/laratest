<?php

namespace Corals\Modules\Medical\database\migrations;

use Corals\Modules\Medical\Enums\ClinicStatuses;
use Corals\Modules\Medical\Enums\DurationUnit;
use Corals\Modules\Medical\Enums\GenderStatus;
use Corals\Modules\Medical\Enums\MaritalStatus;
use Corals\Modules\Medical\Enums\PrescriptionsTypes;
use Corals\Modules\Medical\Enums\VisitStatuses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('medical_cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $this->commonColumns($table);
        });

        Schema::create('medical_villages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('city_id')->constrained('medical_cities')->cascadeOnDelete();
            $this->commonColumns($table);
        });

        Schema::create('medical_patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('national_id', 64)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number', 30)->nullable();
            $table->string('gender')->default(GenderStatus::Male->value);
            $table->string('marital')->default(MaritalStatus::Single->value);
            $table->string('address')->nullable();
            $table->string('full_address')->nullable();
            $table->foreignId('city_id')->constrained('medical_cities')->cascadeOnDelete();
            $table->foreignId('village_id')->constrained('medical_villages')->cascadeOnDelete();
            $table->foreignId('clinic_id')->constrained('medical_clinics')->cascadeOnDelete();
            $this->commonColumns($table);
        });

        Schema::create('medical_clinics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('small_logo')->nullable();
            $table->string('status')->default(ClinicStatuses::Active->value);
            $this->commonColumns($table);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('clinic_id')->nullable()->after('phone_number');
            $table->foreign('clinic_id')->references('id')->on('medical_clinics');
        });

        Schema::create('medical_allergies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('patient_id')->constrained('medical_patients')->cascadeOnDelete();
            $table->foreignId('entered_by')->nullable()->constrained('users')->nullOnDelete();
            $this->commonColumns($table);
        });

        Schema::create('medical_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained('medical_clinics')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('medical_patients')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('visit_status')->default(VisitStatuses::Waiting->value);
            $table->foreignId('registered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_scheduled_visits', function (Blueprint $table) {
            $table->id();
            $table->timestamp('scheduled_at');
            $table->smallInteger('duration_minutes')->unsigned()->default(15);
            $table->text('notes')->nullable();
            $table->foreignId('visit_id')->nullable()->constrained('medical_visits')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('clinic_id')->constrained('medical_clinics')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('medical_patients')->cascadeOnDelete();
            $table->string('visit_status')->default(VisitStatuses::Waiting->value);
            $this->commonColumns($table);
        });

        Schema::create('medical_services', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2)->default(0);
            $table->foreignId('tax_class_id')->nullable()->constrained('tax_classes')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->foreignId('clinic_id')->constrained('medical_clinics')->cascadeOnDelete();
            $this->commonColumns($table);
        });

        Schema::create('medical_service_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('medical_visits')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('medical_services')->restrictOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->string('currency', 3)->nullable();
            $table->text('notes')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_medicine_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $this->commonColumns($table);
        });

        Schema::create('medical_medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('generic_name')->nullable();
            $table->string('strength')->nullable();
            $table->string('form')->nullable();
            $table->string('route')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('medical_visits')->cascadeOnDelete();
            $table->string('type')->default(PrescriptionsTypes::Normal->value);
            $this->commonColumns($table);
        });

        Schema::create('medical_prescription_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained('medical_prescriptions')->cascadeOnDelete();
            $table->foreignId('medicine_id')->nullable()->constrained('medical_medicines')->nullOnDelete();
            $table->foreignId('medicine_type_id')->nullable()->constrained('medical_medicine_types')->nullOnDelete();
            $table->decimal('dosage_amount', 8, 2)->nullable();
            $table->string('dosage_unit', 32)->nullable();
            $table->tinyInteger('times_per_day')->unsigned()->nullable();
            $table->smallInteger('interval_hours')->unsigned()->nullable();
            $table->smallInteger('duration_value')->unsigned()->nullable();
            $table->string('duration_unit')->default(DurationUnit::Days->value);
            $table->string('route', 32)->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->text('notes')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_question_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('public_name')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained('medical_clinics')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('form_title');
            $table->boolean('is_active')->default(true);
            $this->commonColumns($table);
        });

        Schema::create('medical_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('medical_forms')->cascadeOnDelete();
            $table->string('title');
            $table->smallInteger('order')->unsigned()->default(0);
            $table->text('description')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('medical_sections')->cascadeOnDelete();
            $table->smallInteger('order')->unsigned()->default(0);
            $table->foreignId('type_id')->constrained('medical_question_types');
            $table->string('label');
            $table->boolean('is_required')->default(false);
            $table->text('help_text')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('medical_questions')->cascadeOnDelete();
            $table->string('key', 64)->nullable();
            $table->string('value');
            $table->smallInteger('order')->unsigned()->default(0);
            $this->commonColumns($table);
        });

        Schema::create('medical_form_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('medical_forms')->cascadeOnDelete();
            $table->unsignedBigInteger('version');
            $table->string('form_title');
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_section_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_version_id')->constrained('medical_form_versions')->cascadeOnDelete();
            $table->foreignId('section_id')->constrained('medical_sections')->cascadeOnDelete();
            $table->smallInteger('order')->unsigned()->default(0);
            $table->string('title');
            $table->text('description')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_question_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_version_id')->constrained('medical_section_versions')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('medical_questions')->cascadeOnDelete();
            $table->smallInteger('order')->unsigned()->default(0);
            $table->foreignId('type_id')->constrained('medical_question_types');
            $table->string('label');
            $table->boolean('is_required')->default(false);
            $table->text('help_text')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_option_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_version_id')->constrained('medical_question_versions')->cascadeOnDelete();
            $table->string('key', 64)->nullable();
            $table->string('value');
            $table->smallInteger('order')->unsigned()->default(0);
            $this->commonColumns($table);
        });

        Schema::create('medical_form_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained('medical_clinics')->cascadeOnDelete();
            $table->foreignId('form_id')->constrained('medical_forms')->cascadeOnDelete();
            $table->foreignId('form_version_id')->nullable()->constrained('medical_form_versions')->nullOnDelete();
            $table->foreignId('patient_id')->constrained('medical_patients')->cascadeOnDelete();
            $table->foreignId('visit_id')->nullable()->constrained('medical_visits')->nullOnDelete();
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('submitted_at')->useCurrent();
            $table->string('form_title_snapshot')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_form_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('medical_form_submissions')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('medical_form_questions')->cascadeOnDelete();
            $table->foreignId('question_version_id')->nullable()->constrained('medical_question_versions')->nullOnDelete();
            $table->longText('answer_text')->nullable();
            $table->boolean('answer_boolean')->nullable();
            $table->decimal('answer_number', 12, 3)->nullable();
            $table->date('answer_date')->nullable();
            $table->json('answer_json')->nullable();
            $table->string('file_path')->nullable();
            $table->string('question_label_snapshot')->nullable();
            $table->json('options_snapshot')->nullable();
            $this->commonColumns($table);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_form_answers');
        Schema::dropIfExists('medical_form_submissions');
        Schema::dropIfExists('medical_option_versions');
        Schema::dropIfExists('medical_question_versions');
        Schema::dropIfExists('medical_section_versions');
        Schema::dropIfExists('medical_form_versions');
        Schema::dropIfExists('medical_question_options');
        Schema::dropIfExists('medical_questions');
        Schema::dropIfExists('medical_sections');
        Schema::dropIfExists('medical_forms');
        Schema::dropIfExists('medical_question_types');
        Schema::dropIfExists('medical_prescription_items');
        Schema::dropIfExists('medical_prescriptions');
        Schema::dropIfExists('medical_medicines');
        Schema::dropIfExists('medical_medicine_types');
        Schema::dropIfExists('medical_service_items');
        Schema::dropIfExists('medical_services');
        Schema::dropIfExists('medical_scheduled_visits');
        Schema::dropIfExists('medical_visits');
        Schema::dropIfExists('medical_allergies');
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['clinic_id']);
            $table->dropColumn('clinic_id');
        });
        Schema::dropIfExists('medical_clinics');
        Schema::dropIfExists('medical_patients');
        Schema::dropIfExists('medical_villages');
        Schema::dropIfExists('medical_cities');
    }

    protected function commonColumns(Blueprint $table)
    {
        $table->text('properties')->nullable();
        $table->auditable();
        $table->softDeletes();
        $table->timestamps();
    }
}
